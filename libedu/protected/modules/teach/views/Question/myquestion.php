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
		  	type:'POST',
		  	data:{uid:<?php echo Yii::app()->user->id; ?>,chid:cid},
		  	success:function(response){
		  		$('#questiongroupbyitem').html(response);
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
	    			$(data).hide().prependTo(".list-view .items").fadeIn(1500);
	              },
	    error: function(data,err,err1) { // if error occured
	         alert("Error occured.please try again"+err+err1);
	    },
	    dataType:"html"
	  });
}
</script>

<div id="chapterlistforquestion" style="display:none;">
</div>

<ul class="tabs">
    <li class="current">
        <a href="#tab_one">问答首页</a>
    </li>
    <li>
        <a href="#" rel="external">我的提问</a>
    </li>
    <li>
        <a href="#" rel="external">未回答问题</a>
    </li>
    <li>
        <a href="#" rel="external">所有回答</a>
    </li>
    <li>
        <a href="#" rel="external">所有追问</a>
    </li>
    <li>
        <a href="#" rel="external">问题收藏</a>
    </li>
    <li>
        <a href="#" rel="external">我喜欢的问题</a>
    </li>
</ul>
<div class="tabs">
    <div id="tab_one" class="tab padding">
    	<div class="container" rel="2">
    		<div class="carton col_12 nobackground dotbottom">
    			<h2>今天有什么问题么</h2>
    			<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'newquestion-form',
					'enableAjaxValidation'=>false,
				)); 
    				$model = new Question;
    				Yii::app()->getClientScript()->scriptMap=array(
										'jquery.js'=>false,
								);
				?>
				<div id="chapterlist" style="display:none">
					<?php echo $form->textField($model,'item',array('id'=>'questioninput')); ?>
				</div>
				<div class="col_12" style="margin:10px 0;">
					<?php echo $form->error($model,'details'); ?>
					<?php
				$this->widget('application.extensions.redactorjs.Redactor',array(
					'model'=>$model,
					 'width'=>'100%', 'height'=>'150px',
					'attribute'=>'details',
					'editorOptions' => array(
						'imageUpload' => Yii::app()->createAbsoluteUrl('teach/coursepost/upload'),
						'lang'=>'en','toolbar'=>'default',
						)
				));
				?>
				</div>
				<?php $this->endWidget(); ?>
				<div class="container">
					<div class="col_3 offset_9">
						<button onclick="selectChapterForQuestion()" class="col_12 sugar">提问</button>
					</div>	
				</div>
    		</div>
    		<div class="carton col_12 nobackground">
    			<div class="container dotbottom normaltoppadding">
						<a href="javascript:void(0);" onclick="changeToTabByIndex(event,0)" rel="external"><div class="carton col_3">
							<div class="subcontent bordered sail">
								最新的提问
							</div>
						</div></a>

						<a href="javascript:void(0);" onclick="changeToTabByIndex(event,1)" rel="external"><div class="carton col_3">
							<div class="subcontent bordered">
								章节下的提问
							</div>
						</div></a>
					</div>
				<div class="content animated fadeInLeft tinyallpadding">
					

					<?php 
					$this->widget('zii.widgets.CListView', array(
						'dataProvider'=>$dataProvider,
						'itemView'=>'_view',
						 'summaryText'=>'',
					)); ?>
				</div>
				<div class="content animated fadeInLeft">
					<h3>我的问答</h3>
					<div class="row-fluid">
						<div class="span3 well">
							<div id="div1">
								<button onclick="changecontent(2)">get link 2</button>
								<button onclick="changecontent(3)">get link 3</button>
							</div>
								<div id="div4">
									<div id="div2" style="display:none">
										<a href="http://www.google.com" rel="external">Link In Div2</a>
									</div>
									<div id="div3" style="display:none">
										<a href="http://www.baidu.com" rel="external">Link In Div3</a>
									</div>
								</div>
							<script type="text/javascript">
								function changecontent(divid){
									$("#div"+divid).css('display','block');
									$("#div"+divid).siblings().css('display','none');
								}
							</script>
							<h5>选择章节</h5>
							<?php
							/* @var $this UserController */
							/* @var $data User */
								$url = 'question/ajaxFillTree&edition_id='.$eid;
									$this->widget(
										    'CTreeView',
											array(
									            'animated'=>'fast', //quick animation
									            'collapsed' => false,
									            'url' => array( $url ),
											)
									);
							?>


						</div>
						<div class="span9 well" id="questiongroupbyitem">
							&nbsp;
						</div>
					</div>

				</div>
			</div>
    </div>
</div>
</div>






