<?php
/* @var $this LibController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'用户控制面板',
);
?>

<h1>导入学生信息</h1>

<h3 id="subtitle">请选择要导入的文件（只支持.xls 和 .xlsx 文件）</h3>
<?php
			$this->widget('ext.EAjaxUpload.EAjaxUpload',
			array(
			        'id'=>'uploadFile',
			        'config'=>array(
			               'action'=>Yii::app()->createUrl('user/libuser/doimportstudentlist'),
			               'allowedExtensions'=>array("xls","xlsx"),//array("jpg","jpeg","gif","exe","mov" and etc...
			               'sizeLimit'=>10*1024*1024,// maximum file size in bytes
			               //'minSizeLimit'=>10*1024*1024,// minimum file size in bytes
			               'onComplete'=>"js:function(id, fileName, responseJSON){  
										$.post('".Yii::app()->createUrl('user/libuser/loadstudentinfo')."&fname='+responseJSON.filename, { fname:responseJSON.filename }, function(data){
																$('#loadedstuinfo').html(data);
																$('#subtitle').html('请确认您导入的学生信息');
																$('#uploading').fadeOut(200);
																$('#subtitle').fadeIn();
																$('#loadedstuinfo').fadeIn(1000);
														} );
			               }",
			               'onSubmit'=>"js:function(id,fileName){
			               				$('#subtitle').fadeOut();
			               				$('#uploadFile').fadeOut();
										$('#uploading').fadeIn(200);
			               }",
			               'messages'=>array(
			                                 'typeError'=>"{file} has invalid extension. Only {extensions} are allowed.",
			                                 'sizeError'=>"{file} is too large, maximum file size is {sizeLimit}.",
			                                 'minSizeError'=>"{file} is too small, minimum file size is {minSizeLimit}.",
			                                 'emptyError'=>"{file} is empty, please select files again without it.",
			                                 'onLeave'=>"The files are being uploaded, if you leave now the upload will be cancelled."
			                                ),
			               //'showMessage'=>"js:function(message){ alert(message); }"
			              )
			));
?>

<div id="uploading" style="display:none;">
	<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif" />
</div>

<div id="loadedstuinfo" style="display:none">
</div>