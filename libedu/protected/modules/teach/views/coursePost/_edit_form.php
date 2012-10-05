<?php
/* @var $this CoursePostController */
/* @var $model CoursePost */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'course-post-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
	 echo $form->labelEx($model,'post');
	 echo $form->error($model,'post');
?>
<div id="file-upload-notification" style="display:none;color:red">上传成功!!</div>
<script type="text/javascript">
function file_upload_callback( obj , json ){
	$('#file-upload-notification').fadeIn(100);
	$('#file-upload-notification').fadeOut(3000);	
}
</script>
<?php
	$this->widget('application.extensions.redactorjs.Redactor',array(
		'model'=>$model,
		'attribute'=>'post',
		'editorOptions' => array(
				'imageUpload' => Yii::app()->createAbsoluteUrl('teach/coursepost/upload&item_id='.$item_id),
				'fileUpload'  => Yii::app()->createAbsoluteUrl('teach/coursepost/upload&item_id='.$item_id),
				'fileUploadCallback' => "js:file_upload_callback",
				'autosave'=> $base_auto_save_url ,
				'interval' => 5,
				'autosaveCallback'=>"js:function( response,redactor_ins,doc){
					var json_obj = eval( response );
					if ( json_obj.post_id != '' ) {
						redactor_ins.opts.autosave = '" . $base_auto_save_url . "'+ '&post_id=' + json_obj.post_id ;".
						"var createUrl = '" . $base_create_url . "' + json_obj.post_id;" .  
						"doc.getElementById('course-post-form').setAttribute('action' , createUrl );
					}
				}",
				'focus' => false,
		  ),
	));
?>

<div class="row buttons">
		<?php
		 echo CHtml::submitButton('发布' ,  array('name'=>'publish'));
		 echo CHtml::submitButton('存草稿', array('name'=>'draft'));
		 echo CHtml::submitButton('预览' ,  array('name'=>'draft'));
		 echo CHtml::submitButton('取消' ,  array('name'=>'cancel'));
		?>
</div>
	<?php $this->endWidget(); ?>

</div><!-- form -->