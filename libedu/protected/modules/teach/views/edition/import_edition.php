<?php
Yii::app()->getClientScript()->scriptMap=array(
'jquery.js'=>false,
);
?>
<h1>导入知识点</h1>

<h3 id="subtitle">请选择要导入的文件（只支持.xls 和 .xlsx 文件）</h3>


<?php
$this->widget('ext.EAjaxUpload.EAjaxUpload',
		array(
				'id'=>'uploadFile',
				'config'=>array(
						'action'=>Yii::app()->createUrl('/teach/edition/doimportedition'),
						'allowedExtensions'=>array("xls","xlsx"),
						'sizeLimit'=>10*1024*1024,// maximum file size in bytes
						'onComplete'=>"js:function(id, fileName, responseJSON){
										$.post('".Yii::app()->createUrl('teach/edition/loadedition' )."&fname='+responseJSON.filename, { fname:responseJSON.filename }, function(data){
																$('#loadedition').html(data);
																$('#subtitle').html('请您仔细确认导入的知识点信息。');
																$('#loadedition').fadeIn(1000);
																$('#confirmimportbtn').attr('rel',responseJSON.filename);
																$('#confirmimportbtn').fadeIn();
																$('.fancybox-wrap').stop(true).trigger('onReset').fadeOut(500);
																$('.fancybox-overlay').fadeOut();
																$('body').removeClass('fancybox-lock');
														} );
			               }",
						'onSubmit'=>"js:function(id,fileName){
			               				$('#subtitle').html('文件正在上传中……');
			               				$('#uploadFile').fadeOut();
										$('#loadinghover').trigger('click');
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
<?php echo CHtml::ajaxButton ("确认导入教材信息",
                              CController::createUrl('/teach/edition/writeedition'), 
                              array('update' => '#loadedition',
                              		'data'=>'js:{fname: $(this).attr(\'rel\')}',
                              		'beforeSend'=>'js:function(){$(\'#loadinghover\').trigger(\'click\');}',
                              		'complete'=>'js:function(){
                              	$(\'#confirmimportbtn\').fadeOut();$(\'#subtitle\').fadeOut();
                              	$(\'.fancybox-wrap\').stop(true).trigger(\'onReset\').fadeOut(500);
								$(\'.fancybox-overlay\').fadeOut();$(\'body\').removeClass(\'fancybox-lock\');}'),
					array('style'=>'float:right;display:none','id'=>'confirmimportbtn')); ?>
<?php $this->widget('application.extensions.fancybox.EFancyBox', array(
        'target'=>'a.fancylink',
        'config'=>array('minWidth'=>'300px','minHeight'=>'100px','closeBtn'=>false),));  
?> 
<div id="loadedition" style="display:none">
</div>
<a href="#fancydata" class="fancylink" id="loadinghover" style="display:none">&nbsp;</a>
<div style="display:none">
	<div id="fancydata">
		<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif" />
		<p>文件正在上传中.................</p>
	</div>
</div>