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
<input type="text" id="CoursePost_title" name="CoursePost[post_title]" height="10px" 
		placeholder="请填写课程题目">
</input>

<div id="file-upload-notification" style="display:none;color:red">上传成功!!</div>
<div id="upload-file-name" style="border-width:thin;border-style:solid;border-color:gray;color:red;display:none"></div>
<script type="text/javascript">
function file_upload_callback( obj , json ){
	$('#file-upload-notification').fadeIn(100);
	$('#file-upload-notification').fadeOut(3000);
	var upload_ret = eval( '(' + json + ')');
	$('#upload-file-name').append("<p>上传文档:[ " +upload_ret.file_name +"] 成功,文档状态：正在转换中</p>");
	$('#upload-file-name').show();	
	$('#course-post-form').append("<input name='mid[]" + upload_ret.mid + "' value='" + upload_ret.mid + "' style='display:none'></input>");
}
</script>
<h2>课程内容:</h2>
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

<div class="white">
<button name="publish" type="submit">发布</button>
<button name="draft" type="submit">预览</button>
<button name="cancel" type="submit">预览</button>
</div>
	<?php $this->endWidget(); ?>

</div><!-- form -->