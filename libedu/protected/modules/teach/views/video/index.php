<?php
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

	/*if(targettabindex == 0){
		var refreshurl = '<?php echo Yii::app()->createUrl("/teach/question/myquestion",array("refreshafteraddquestion"=>1)); ?>';
	    $('#recentquestions').html('<div class="libajaxloader"></div>');
	    $('#recentquestions').load(refreshurl).hide().fadeIn(300);
	    $('#questiongroupbyitem').hide().html(' ');
	}

	if(targettabindex == 1){
		$('#recentquestions').hide().html(' ');
	}*/

}

function closemodal(){
			$('#overlays .modal').fadeOut(100);
			$('#overlays').removeClass();
			$(document).unbind('keyup');	
}


</script>

<div id="changecoursecontent" class="col_12" style="display:none">
		<h3>修改课程内容</h3>
		<p class="col_6">
			<label for="coursename">课程名</label>
			<input type="text" name="coursename" />
		</p>
		<p class="col_6">
			<label for="coursename">课程描述</label>
			<input type="text" name="coursedescription" />
		</p>
		<p class="col_12">
			 公开 <input type="checkbox" class="modalcheckbox sunlit"> | 
		
			
			 仅限本班学生 <input type="checkbox" class="modalcheckbox sunlit"> | 
		
		
			 密码 <input type="checkbox" class="modalcheckbox sunlit pwdtoogle" > 
		</p>
		<p  style="display:none" class="pwdinput" >
			<input type="text"/>
		</p>

		<p class="col_5">
			<label>课程日期</label>
			<input type="text" />
		</p>
		<p class="col_3">
			<label>从</label>
			<input type="text" />
		</p>
		<p class="col_3 offset_1">
			<label>到</label>
			<input type="text" />
		</p>
		<p class="col_12" style="text-align:right;">
			<button class="sugar" onclick="window.location='<?php echo Yii::app()->createUrl('teach/video/view',array('id'=>13)); ?>';">确认</button>
			<button class="sugar" onclick="closemodal();">取消</button>
		</p>
</div>


<div id="chapterlistforquestion" style="display:none;">
</div>

<ul class="tabs">
    <li class="current">
        <a href="#tab_one">我的视频面授
</a>
    </li>
    <li>
        <a href="<?php echo Yii::app()->createUrl('/teach/question/questionfromme'); ?>" rel="external">我关注的视频面授
</a>
    </li>
    <li>
        <a href="<?php echo Yii::app()->createUrl('/teach/question/questionnotanswered'); ?>" rel="external">我喜欢的视频面授
</a>
    </li>
</ul>
<div class="tabs">
    <div id="tab_one" class="tab padding">
    	<div class="container" rel="2">
    		<div class="carton col_12 nobackground">
    			<div class="container dotbottom normaltoppadding">
						<a href="javascript:void(0);" onclick="changeToTabByIndex(event,0)" rel="external"><div class="carton col_3">
							<div class="subcontent bordered sail">
								最近的视频面授
							</div>
						</div></a>

						<a href="javascript:void(0);" onclick="changeToTabByIndex(event,1)" rel="external"><div class="carton col_3">
							<div class="subcontent bordered">
								所有视频面授
							</div>
						</div></a>

						<a href="javascript:void(0);" onclick="$('#changecoursecontent').modal();initcheckbox();" rel="external"><div class="carton col_3 offset_3">
							<div class="subcontent bordered">
								<span class="iconclass min" style="line-height:12px; font-size:24px;">+</span>创建视频面授
							</div>
						</div></a>
					</div>
				<div class="content animated fadeInLeft tinyallpadding" id="recentquestions" style="min-height:200px;">
					<div class="container tinytinyallpadding">
						<div class="col_12 roundbordered normalbottommargin">
							<div class="col_1">
								<span class="iconclass mid">
									F
								</span>	
							</div>
							<div class="col_6 offset_1">
								<h3>正弦函数</h3>
								<p>主讲时间 <?php echo date("Y-m-d H:i:s"); ?></p>
							</div>
							<div class="col_2 videoitemcontrol normaltoppadding">
								<p class="sail roundbordered" style="text-align:center">正常 <span><a href="javascript:void(0);">取消</a></span></p>
							</div>
							<div class="col_2 normaltoppadding">
								<a href="<?php echo Yii::app()->createUrl('/teach/video/view');?>" rel="external"><button>进入教室</button></a>
							</div>
						</div>

						<div class="col_12 roundbordered normalbottommargin">
							<div class="col_1">
								<span class="iconclass mid">
									F
								</span>	
							</div>
							<div class="col_6 offset_1">
								<h3>余弦函数</h3>
								<p>主讲时间 <?php echo date("Y-m-d H:i:s",time()-61*61*2); ?></p>
							</div>
							<div class="col_2 videoitemcontrol normaltoppadding">
								<p class="sugar roundbordered" style="text-align:center">正在进行</p>
							</div>
							<div class="col_2 normaltoppadding">
								<a href="<?php echo Yii::app()->createUrl('/teach/video/view');?>"><button>进入教室</button></a>
							</div>
						</div>


					</div>
				</div>
				<div class="content animated fadeInLeft tinytinyallpadding">
					<div class="container tinytinyallpadding">
						<div class="col_12 roundbordered normalbottommargin">
							<div class="col_1">
								<span class="iconclass mid">
									F
								</span>	
							</div>
							<div class="col_6 offset_1">
								<h3>正弦函数</h3>
								<p>主讲时间 <?php echo date("Y-m-d H:i:s"); ?></p>
							</div>
							<div class="col_2 videoitemcontrol normaltoppadding">
								<p class="sail roundbordered" style="text-align:center">正常 <span><a href="javascript:void(0);">取消</a></span></p>
							</div>
							<div class="col_2 normaltoppadding">
								<a href="<?php echo Yii::app()->createUrl('/teach/video/view');?>"><button>进入教室</button></a>
							</div>
						</div>

						<div class="col_12 roundbordered normalbottommargin">
							<div class="col_1">
								<span class="iconclass mid">
									F
								</span>	
							</div>
							<div class="col_6 offset_1">
								<h3>余弦函数</h3>
								<p>主讲时间 <?php echo date("Y-m-d H:i:s",time()-61*61*2); ?></p>
							</div>
							<div class="col_2 videoitemcontrol normaltoppadding">
								<p class="sugar roundbordered" style="text-align:center">正在进行</p>
							</div>
							<div class="col_2 normaltoppadding">
								<a href="<?php echo Yii::app()->createUrl('/teach/video/view');?>"><button>进入教室</button></a>
							</div>
						</div>

						<div class="col_12 roundbordered normalbottommargin">
							<div class="col_1">
								<span class="iconclass mid">
									F
								</span>	
							</div>
							<div class="col_6 offset_1">
								<h3>另外一个函数</h3>
								<p>主讲时间 <?php echo date("Y-m-d H:i:s",time()-61*61*10); ?></p>
							</div>
							<div class="col_2 videoitemcontrol normaltoppadding">
								<p class="lightgrey roundbordered" style="text-align:center">已结束</p>
							</div>
							<div class="col_2 normaltoppadding">
								<a href="<?php echo Yii::app()->createUrl('/teach/video/view');?>"><button>进入教室</button></a>
							</div>
						</div>

					</div>
				</div>
			</div>
    </div>
</div>
</div>




<script type="text/javascript">
	function initcheckbox(){
		$(".checkbox").click(function () {
			if($(this).hasClass('checked')){
				$(this).removeClass('checked');
				if($(this).hasClass('pwdtoogle')){
					$('.pwdinput').fadeOut();
				}
			}else{
				$(this).addClass('checked');
				if($(this).hasClass('pwdtoogle')){
					$('.pwdinput').fadeIn();
				}else{
					$('.pwdinput').fadeOut();
				}
				$(this).siblings('span.checked').removeClass('checked');
				
			}
		});
	}
	$(document).ready(function(){
		$("input:checkbox").each(function () {
			$(this).checkbox();	
		});
	});
</script>