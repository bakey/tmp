<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'task-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($task_model); ?>
	<div class="row">
		<?php echo $form->labelEx($task_model,'测验名'); ?>
		<?php echo $form->textField($task_model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($task_model,'name'); ?>
	</div>
	
	<div class="row">
			<?php echo $form->labelEx($task_model,'测试描述'); ?>
			<?php echo $form->textArea($task_model,'description',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($task_model,'description'); ?>
	</div>
	
	<div class="row" id="item_tree">
	<h3>关联本课程以下章节</h3>
	<?php 
	$course_id = Yii::app()->user->course;
	$url = 'task/ajaxloaditem';
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
	
	<h4 id="hint_text" style="display:none">您已选择关联的章节：
	<span id="relation_item" style='color:red'>
	</span>
	</h4>
		
		

	<div class="row"  style="display:none">
		<?php echo $form->labelEx($task_model,'item'); ?>
		<?php echo $form->textField($task_model,'item',array('id'=>'selected_item')); ?>
		<?php echo $form->error($task_model,'item'); ?>
	</div>
	
	<div id="wrap_kp" class="row"  style="display:none">
	</div>
	
	<?php
	$this->renderPartial( 'select_problem' , array(
			'problem_data' => $problem_data,
		) );
	 
	?>

	<div id="statusID"></div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('创建测试' , array('name'=>'publish')); ?>
		<?php echo CHtml::submitButton('预览试卷' , array('name'=>'preview')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
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