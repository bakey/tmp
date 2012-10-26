<?php
/* @var $this QuestionController */
/* @var $dataProvider CActiveDataProvider */

/*$this->menu=array(
	array('label'=>'Create Question', 'url'=>array('create')),
	array('label'=>'Manage Question', 'url'=>array('admin')),
);*/

Yii::app()->getClientScript()->scriptMap=array(
										'jquery.js'=>false,
										'styles.css'=>false,
										//'pager.css'=>false,
								);
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

function doselectchapter(event,cid){
	if($(event.target).parents('#modaltreeview').length >0){
		$('#questioninput').val(cid);
		$('#selectedchapterforquestion').html('您选择了章节： '+ $('.modal #child'+cid).text());
	}else{
		$.ajax({
		  	url:'<?php echo Yii::app()->createUrl("/teach/question/getquestionbyitem"); ?>',
		  	type:'GET',
		  	data:{uid:<?php echo Yii::app()->user->id; ?>,chid:cid},
		  	success:function(response){
		  		$('#questiongroupbyitem').html(response).hide().fadeIn();
		  	},
		 });
	}
}

function selectChapterForQuestion(){
	$.fn.modal({
		'url':'<?php echo Yii::app()->createUrl("/teach/question/getchapterfromcourse"); ?>',
		'width':500,
		'padding':'20px',
	});

	$('#overlays .modal').bind('DOMSubtreeModified', function(event) {
		$("#overlays .modal").css("height",parseInt($("#modaltreeview").height())+280+"px");
	});
}

function submitQuestion(){
		var data1=$("#newquestion-form").serialize();
		$.ajax({
	    type: "POST",
	    url: '<?php echo Yii::app()->createUrl("/teach/question/create"); ?>',
	    data:data1,
	    success:function(data){
	    			closemodal();
	    			$.notification ( 
					    {
					        title:      '提问成功',
					        content:    '哈哈！'
					    }
					);
					var refreshurl = '<?php echo Yii::app()->createUrl("/teach/question/myquestion",array("refreshafteraddquestion"=>1)); ?>';
	    			$('#recentquestions').html('<div class="libajaxloader"></div>');
	    			$('#recentquestions').load(refreshurl).hide().fadeIn(300);
	              },
	    error: function(data,err,err1) { // if error occured
	         alert("Error occured.please try again"+err+err1);
	    },
	    dataType:"html"
	  });
}
$(document).ready(function(){
	$('#recentquestions .pager a[data-href]').attr('href',function(i) {
	    	$(this).attr('href', $(this).attr('data-href'));
	});
	$('#questionsgroupbyitemlist .yiiPager a[href]').attr('data-href',function(i) {
	    	$(this).attr('data-href', $(this).attr('href'));
	});
});
</script>

<div id="chapterlistforquestion" style="display:none;">
</div>

<ul class="tabs">
    <li class="side_bar_word">
        <a href="<?php echo Yii::app()->createUrl('/teach/question/myquestion'); ?>" rel="external">问答首页</a>
    </li>
    <li class="current side_bar_word">
        <a href="#tab_one" rel="external">我的提问</a>
    </li>
    <li class="side_bar_word">
        <a href="<?php echo Yii::app()->createUrl('/teach/question/questionnotanswered'); ?>" rel="external">未回答问题</a>
    </li>
    <li class="side_bar_word">
        <a href="<?php echo Yii::app()->createUrl('/teach/question/allmyansweredquestion'); ?>" rel="external">所有回答</a>
    </li>
    <li class="side_bar_word">
        <a href="#" rel="external">所有追问</a>
    </li>
    <li class="side_bar_word">
        <a href="#" rel="external">问题收藏</a>
    </li>
    <li class="side_bar_word">
        <a href="#" rel="external">我喜欢的问题</a>
    </li>
</ul>
<div class="tabs">
    <div id="tab_one" class="tab padding">
    	<div class="container" rel="2">
    		<div class="carton col_12 nobackground">
				<div class="content animated fadeInLeft tinyallpadding" id="recentquestions" style="min-height:200px;">
					

					<?php 
					$this->widget('zii.widgets.CListView', array(
						'dataProvider'=>$dataProvider,
						'itemView'=>'_view',
						 'summaryText'=>'',
						 'id'=>'myrecentquestions',
        				'ajaxUpdate'=>true,
        				'pager'=>array('pageSize'=>5),
					)); ?>
				</div>
			</div>
    </div>
</div>
</div>






