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
	'id'=>'question-form'.$qid,
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('class'=>'well'),
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="carton">
		<h2>回答问题</h2>
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
		<div class="container">
			<div class="col_4 roundbordered">
				<label>知识点关联</label>
				<p><?php echo CHtml::checkBoxList('kprelation',$skp,$kp);?></p>
			</div>	
			<div class="col_7 roundbordered">
				<?php echo CHtml::label('请选择回答类型','Answer[type]',array('required'=>true));?>
				<?php echo CHtml::dropDownList('Answer[type]',2,array('0'=>'评论','1'=>'追问','2'=>'回答'));?>
			</div>		
		</div>
	</div>

<?php $this->endWidget(); ?>
	<div class="col_12" style="margin:10px 0;">
		<button onclick="submitAnswer(<?php echo $qid;?>)" class="col_12 sugar">提交回答</button>
	</div>
</div><!-- form -->
