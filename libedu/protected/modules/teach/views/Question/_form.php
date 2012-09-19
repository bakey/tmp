<?php
/* @var $this QuestionController */
/* @var $model Question */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'question-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
	<h4 id="chapternotification" style="display:none">您已选择章节：<span id="chapternotificationname"></span>。<a href="#" onclick="reselect()">重新选择</a></h4>
	<?php echo $form->errorSummary($model); ?>
	
	<div class="row" id="choosecourse">
		<label for="courseid">选择课程</label>
		<?php
			echo CHtml::dropDownList('courseid',null,$mycourse,array());
			echo CHtml::ajaxButton('获得章节',Yii::app()->createUrl('/teach/question/getchapterfromcourse'),array('update'=>'#coursedata','type'=>'POST','data'=>'js:{"cid":$("#courseid").val()}'));
		?>
		<div class="row" id="coursedata">
		</div>
	</div>
	<div class="row" id="chapterlist" style="display:none">
		<?php echo $form->labelEx($model,'item'); ?>
		<?php echo $form->textField($model,'item',array('id'=>'questioninput')); ?>
		<?php echo $form->error($model,'item'); ?>
	</div>
	<div class="row">
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

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? '提交' : '保存'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
	function doselectchapter(iid){
		$('#questioninput').val(iid);
		$('#chapternotificationname').text($('#child'+iid).text());
		$('#choosecourse').fadeOut(300);
		$('#chapternotification').fadeIn(300);
	}

	function reselect(){
		
		$('#chapternotification').fadeOut(300);	
		$('#choosecourse').fadeIn(300);
	}
</script>