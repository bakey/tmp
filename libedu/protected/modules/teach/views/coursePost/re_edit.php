<?php 
$this->breadcrumbs=array(
	'课程资料'=>array('/teach/course/update&course_id='.$course_id),
	'重新编辑',
);
?>
<div class="form">
<?php 
$form=$this->beginWidget('CActiveForm', array(
		'id'=>'course-post-form',
		'action' => $baseCreateUrl ,
		'enableAjaxValidation'=>false,
));
echo $form->labelEx($post_model,'post');
?>
<?php	
	$this->widget('application.extensions.redactorjs.Redactor',array(
		'model'=>$post_model,
		'attribute'=>'post',
		'editorOptions' => array(
				'imageUpload' => Yii::app()->createAbsoluteUrl('teach/coursepost/upload'),
				'fileUpload'  => Yii::app()->createAbsoluteUrl('teach/coursepost/upload'),
				'autosave'=> $baseAutoSaveUrl,
				'interval' => 5,
				'autosaveCallback'=>"js:function(data,redactor_ins,doc){
					var json_obj = eval( data );
					redactor_ins.opts.autosave = '" . $baseAutoSaveUrl . "';".
					"var createUrl = '" . $baseCreateUrl . "';" .  
					"doc.getElementById('course-post-form').setAttribute('action' , createUrl );				 
				}",
				'focus' => false,
		  ),
	));
?>
<div class="row buttons">
		<?php
		 echo CHtml::submitButton('发布' , array('name'=>'publish'));
		 echo CHtml::submitButton('存草稿' , array('name'=>'draft'));
		 echo CHtml::submitButton('预览' , array('name'=>'draft'));
		 echo CHtml::submitButton('取消' , array('name'=>'cancel'));
		?>
	</div>

<?php $this->endWidget(); ?>
</div>