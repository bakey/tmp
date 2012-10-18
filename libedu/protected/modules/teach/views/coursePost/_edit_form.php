<script type="text/javascript">
function checkPost()
{
	if ( $('#CoursePost_title').val() == "" || $('#CoursePost_post').val() == "" )  {
		alert('课程资料题目和课程内容都不能为空');
		return false;
	}
	else
	{
		return true;
	}
}
</script>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'course-post-form',
	'enableAjaxValidation'=>true,
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
	$('#CoursePost_post').insertHtml('<img src="http://<?php echo Yii::app()->params['web_host']; ?>/dev/libedu/static/images/converting.png" class="doc_placeholder"></img>');
	var media_node = '<input name="mid[]" style="display:none" value="' + upload_ret.mid + '">';
	$( media_node ).insertAfter( '#CoursePost_title' );	
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
				'interval' => 10,
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
<button name="publish" type="submit" onclick="return checkPost();">发布</button>
<button name="draft" type="submit">预览</button>
<button name="draft" type="submit">存草稿</button>
<button name="cancel" type="submit">取消</button>
</div>
	<?php $this->endWidget(); ?>

</div><!-- form -->