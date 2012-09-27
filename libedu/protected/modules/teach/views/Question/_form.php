<?php
/* @var $this QuestionController */
/* @var $model Question */
/* @var $form CActiveForm */
?>
<p class="note">Fields with <span class="required">*</span> are required.</p>
	
<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'question-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('class'=>'well'),
)); ?>

	<div class="alert alert-block alert-success" id="chapternotificationcover" style="display:none">
	   <p id="chapternotification">您已选择章节：<span id="chapternotificationname"></span>。<a href="javascript:void(0)" onclick="reselect()">重新选择</a></p>
	</div>
	
	<?php echo $form->errorSummary($model); ?>
	
	<div id="choosecourse">
		<label for="courseid">选择课程</label>
		<?php
			echo CHtml::dropDownList('courseid',null,$mycourse,array());
			echo '<br />';
			echo CHtml::ajaxButton('获得章节',Yii::app()->createUrl('/teach/question/getchapterfromcourse'),array('update'=>'#coursedata','type'=>'POST','data'=>'js:{"cid":$("#courseid").val()}'),array('class'=>'btn'));
		?>
		<div id="coursedata">
		</div>
	</div>
	<div id="chapterlist" style="display:none">
		<?php echo $form->labelEx($model,'item'); ?>
		<?php echo $form->textField($model,'item',array('id'=>'questioninput')); ?>
		<?php echo $form->error($model,'item'); ?>
	</div>
	<hr />
	<div >
		<?php echo $form->labelEx($model,'details'); ?>
		<?php
	$this->widget('application.extensions.redactorjs.Redactor',array(
		'model'=>$model,
		'attribute'=>'details',
		'editorOptions' => array(
			'imageUpload' => Yii::app()->createAbsoluteUrl('teach/coursepost/upload'),
			)
	));
	?>
		<?php echo $form->error($model,'details'); ?>
	</div>

	<div class="buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? '提交' : '保存',array('class'=>'btn')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
	function doselectchapter(iid){
		$('#questioninput').val(iid);
		$('#chapternotificationname').text($('#child'+iid).text());
		$('#choosecourse').fadeOut(300);
		$('#chapternotificationcover').fadeIn(300);
	}

	function reselect(){
		
		$('#chapternotificationcover').fadeOut(300);	
		$('#choosecourse').fadeIn(300);
	}
</script>