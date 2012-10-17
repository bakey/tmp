<?php
/* @var $this QuestionController */
/* @var $model Question */
/* @var $form CActiveForm */


Yii::app()->getClientScript()->scriptMap=array(
										'jquery.js'=>false,
								);

?>



<div class="container">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>isset($level)?'subquestion-form'.$qid:'question-form'.$qid,
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="carton">
		<h2><?php echo $anstyp==1? '追问' : '回答'; ?></h2>
		<div class="col_12" style="margin:10px 0;">
			<?php echo $form->error($model,'details'); ?>
			<?php
		$this->widget('application.extensions.redactorjs.Redactor',array(
			'model'=>$model,
			 'width'=>'100%', 'height'=>'150px',
			'attribute'=>'details',
			'htmlOptions'=>array('id'=>uniqid()),
			'editorOptions' => array(
				'imageUpload' => Yii::app()->createAbsoluteUrl('teach/coursepost/upload'),
				'lang'=>'en','toolbar'=>'mini',
				)
		));
		?>
		<input type="hidden" name="Answer[type]" value="<?php echo $anstyp; ?>" />
		</div>
	</div>

<?php $this->endWidget(); ?>
	<div class="col_12" style="margin:10px 0;">
		<button onclick="submit<?php if(isset($level)){if($level == 2) echo 'Subb'; else echo 'Sub';}  ?>Answer(<?php echo $qid;?>)" class="col_12 sugar">提交<?php echo $anstyp==1? '追问' : '回答';?></button>
	</div>
</div><!-- form -->
