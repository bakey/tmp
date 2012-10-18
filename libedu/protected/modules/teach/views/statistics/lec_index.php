<?php
/* @var $this StatisticsController */
/* @var $this QuestionController */
/* @var $dataProvider CActiveDataProvider */

/*$this->menu=array(
	array('label'=>'Create Question', 'url'=>array('create')),
	array('label'=>'Manage Question', 'url'=>array('admin')),
);*/
?>

<script type="text/javascript">
function changeToTabByIndex(event,targettabindex) {
	var index = $(event.target).index();
	index = targettabindex;
	var carton = $(event.target).parent().parent().parent().parent();
	
	carton.children("ul").children("li.current").removeClass("current");
	carton.children("ul").children("li").eq(index).addClass("current");
	
	carton.children(".content.current").removeClass("current");
	carton.children(".content").eq(index).addClass("current");
	carton.slideDown();
	$(event.target).parent().parent().siblings().children(".carton").children(".subcontent").removeClass('sail');
	$(event.target).addClass('sail');

	if(targettabindex == 0){
		var refreshurl = '<?php echo Yii::app()->createUrl("/teach/question/myquestion",array("refreshafteraddquestion"=>1)); ?>';
	    $('#recentquestions').html('<div class="libajaxloader"></div>');
	    $('#recentquestions').load(refreshurl).hide().fadeIn(300);
	    $('#questiongroupbyitem').hide().html(' ');
	}

	if(targettabindex == 1){
		$('#recentquestions').hide().html(' ');
	}

}

function closemodal(){
			$('#overlays .modal').fadeOut(100);
			$('#overlays').removeClass();
			$(document).unbind('keyup');	
}

function flipUpOthers(){
	$(".tabheader").siblings().not(".current").fadeOut();
}

$(document).ready(function(){
	$(".tabs .current").siblings().not(".tabheader").fadeOut();
});
</script>

<div id="chapterlistforquestion" style="display:none;">
</div>

<ul class="tabs">
	<li class="tabheader">
        <h3>课程统计<span class="iconclass min">]</span></h3>
    </li>
    <li>
        <a href="#tab_one">热点统计</a>
    </li>
    <li>
        <a href="#tab_one">浏览统计</a>
    </li>
    <li>
        <a href="#tab_one">共建统计</a>
    </li>
    <li>
        <a href="#tab_one">来访统计</a>
    </li>
    <li class="tabheader">
        <h3>测试统计<span class="iconclass min">]</span></h3>
    </li>
    <li class="current">
        <a href="#tab_one">热点统计</a>
    </li>
    <li>
        <a href="#tab_one">得分统计</a>
    </li>
    <li>
        <a href="#tab_one">错题与知识点统计</a>
    </li>
    <li>
        <a href="#tab_one">共建统计</a>
    </li>
    <li class="tabheader">
        <h3>问答统计<span class="iconclass min">]</span></h3>
    </li>
    <li>
        <a href="#tab_one">热点统计</a>
    </li>
    <li>
        <a href="#tab_one">知识点统计</a>
    </li>
    <li>
        <a href="#tab_one">学生统计</a>
    </li>
    <li>
        <a href="#tab_one">章节统计</a>
    </li>

</ul>
<div class="tabs">
    <div id="tab_one" class="tab padding">
    	<div class="container" rel="2">
    		<div class="carton col_12 nobackground">
    			<div class="container dotbottom normaltoppadding">
						<a href="javascript:void(0);" onclick="changeToTabByIndex(event,0)" rel="external"><div class="carton col_3">
							<div class="subcontent bordered sail">
								最近
							</div>
						</div></a>

						<a href="javascript:void(0);" onclick="changeToTabByIndex(event,1)" rel="external"><div class="carton col_3">
							<div class="subcontent bordered">
								每月
							</div>
						</div></a>

						<a href="javascript:void(0);" onclick="changeToTabByIndex(event,2)" rel="external"><div class="carton col_3">
							<div class="subcontent bordered">
								累计
							</div>
						</div></a>
					</div>
				<div class="content animated fadeInLeft tinytinyallpadding" style="min-height:200px;">
					<div class="container">
						<div class="col_12 roundbordered carton  normalbottommargin dotbottom">
							<?php 
								Yii::app()->getClientScript()->scriptMap=array(
										'jquery.js'=>false,
								);
								$this->Widget('ext.highcharts.HighchartsWidget', array(
								   'options'=>array(
								      'title' => array('text' => '我最近7天发布的测试被完成次数统计(TOP10)'),
								      'chart' =>array('type'=>'column'),
								      'credits'=>array('enabled'=>false),
								      'xAxis' => array(
								         'categories' => $xaxisarray,
								      ),
								      'legend'=>array('enabled'=>false),
								      'yAxis' => array(
								         'title' => array('text' => '完成次数')
								      ),
								      'series' => array(
								         $dataArray = array('name'=>'完成次数','data' => $dataarray),
								      )
								   )
								));
							?>
						</div>
						<div class="col_12 roundbordered carton">
							<table>
								<thead>
									<tr>
										<th>编号</th>
										<th>测试名</th>
										<th>完成次数</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										$ttl = 0;
										foreach($ctask as $singletask){
											$ttl ++;
											echo '<tr><td>测试'.$ttl.'</td><td>'.$singletask->name.'</td><td>'.$singletask->numberoftaken.'</td></tr>';
										}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="content animated fadeInLeft tinytinyallpadding">
					<div class="container">
						<div class="col_12 roundbordered carton">
							<h1>This Is Tab 二</h1>
						</div>
					</div>

				</div>

				<div class="content animated fadeInLeft tinytinyallpadding">
					<div class="container">
						<div class="col_12 roundbordered carton">
							<div class="col_12 roundbordered carton  normalbottommargin">
							<?php 
								Yii::app()->getClientScript()->scriptMap=array(
										'jquery.js'=>false,
								);
								$this->Widget('ext.highcharts.HighchartsWidget', array(
								   'options'=>array(
								      'title' => array('text' => '我最近7天发布的测试被完成次数统计(TOP10)'),
								      'chart' =>array('type'=>'column'),
								      'credits'=>array('enabled'=>false),
								      'xAxis' => array(
								         'categories' => $xaxisarray,
								      ),
								      'legend'=>array('enabled'=>false),
								      'yAxis' => array(
								         'title' => array('text' => '完成次数')
								      ),
								      'series' => array(
								         $dataArray = array('name'=>'完成次数','data' => $dataarray),
								      )
								   )
								));
							?>
						</div>
						<div class="col_12 roundbordered carton">
							<table>
								<thead>
									<tr>
										<th>编号</th>
										<th>测试名</th>
										<th>完成次数</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										$ttl = 0;
										foreach($ctask as $singletask){
											$ttl ++;
											echo '<tr><td>测试'.$ttl.'</td><td>'.$singletask->name.'</td><td>'.$singletask->numberoftaken.'</td></tr>';
										}
									?>
								</tbody>
							</table>
						</div>
						</div>
					</div>

				</div>
			</div>
    </div>
</div>
</div>






