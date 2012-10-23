<script type="text/javascript">
function connect_with_item( task_id )
{
	if( $('#problem_selected').children().length <= 0 ) {
		alert("你还没有选择题目");
		return false ;
	}
	$.fn.modal({
		url : '<?php echo Yii::app()->params['index_path']?>?r=teach/task/connectitem&task_id=' + task_id ,
    	///theme:      "dark",
    	width:      480,
    	height:     360,
    	/*layout:     "elastic",
    	url:        undefined,
    	content:    "<strong>HTML</strong> content",
    	padding:    "100px",*/
    	animation:  "fadeIn"
	});
}
function submit_task_form( task_id )
{
	$.ajax( 
	{
		url : 'index.php?r=teach/task/create&task_id=' + task_id ,
		data : $("#task-form").serialize(),
		type : 'post',
		success: function( resp ) {
			var submit_ret = eval( '(' + resp + ')' );
			window.location.href = submit_ret.redir_url;
		}
	}
);
	
	
}

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
</script>

<div class="container tinytinyallpadding">
	<div class="carton nobackground col_8">
		<div class="container dotbottom normaltoppadding">
						<a href="javascript:void(0);" onclick="changeToTabByIndex(event,0)" rel="external"><div class="carton col_3">
							<div class="subcontent bordered sail">
								题库选题
							</div>
						</div></a>

						<a href="javascript:void(0);" onclick="changeToTabByIndex(event,1)" rel="external"><div class="carton col_3">
							<div class="subcontent bordered">
								收藏的题
							</div>
						</div></a>

						<a href="javascript:void(0);" onclick="changeToTabByIndex(event,1)" rel="external"><div class="carton col_3">
							<div class="subcontent bordered">
								自己出题
							</div>
						</div></a>

						<a href="javascript:void(0);" onclick="changeToTabByIndex(event,1)" rel="external"><div class="carton col_3">
							<div class="subcontent bordered">
								测试过的试卷
							</div>
						</div></a>
					</div>
				<div class="content animated fadeInLeft tinytinyallpadding" id="recentquestions" style="min-height:200px;">
					

<div class="form">
						<?php $form=$this->beginWidget('CActiveForm', array(
							'id'=>'task-form',
							'enableAjaxValidation'=>false,
						)); ?>
						
						<?php echo $form->errorSummary($task_model); ?>		
						<div id="problem_selected" style="display:none"></div>	
						<?php
							$this->renderPartial( 'select_problem' , array(
								'problem_data' => $problem_data,
							) );
						?>
						
						<div id="item_selected" style="display:none"></div>
						

						<?php $this->endWidget(); ?>

					</div><!-- form -->
				</div>
				<div class="content animated fadeInLeft tinyallpadding" id="recentquestions" style="min-height:200px;">
					dsafs
				</div>


	</div>

	<div class="col_4">
		<div class="col_12">
			<span class>
			               测试名: &nbsp; <?php echo $task_model->name ; ?>
				<br>您已勾选<span id="choice_problem_cnt">0</span>道选择题
			</span>
			<span style="">
				<button onclick="connect_with_item(<?php echo $task_model->id; ?>);" style="float:right;">下一步</button>
			</span>
		</div>
	</div>
</div>

	<script type="text/javascript">
		function select_item( cid ){	
			$('#selected_item').val(cid);	
			$('#hint_text').fadeIn(300);
			$('#item_tree').fadeOut(300);
			$('#relation_item').text( $('#'+cid).text() );
		}
		function select_kp( kpid ) {
			$('#hint_select_kp').fadeIn(300);
			$('#hint_select_kp').append('<span syle=\'color:blue\'>' + $('#kp_'+kpid).text() +'</span>,');
			$('#wrap_kp').append('<input name="Task[kp][]" type="text" value="'+kpid+'" />');		
		}
		
	</script>