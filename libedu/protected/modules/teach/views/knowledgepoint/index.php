<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	$this->module->id,
);
?>

<p>
知识点管理
</p>
<p>

<h1>导入知识点</h1>

<h3 id="subtitle">请选择要导入的文件（只支持.xls 和 .xlsx 文件）</h3>


<?php
			$this->widget('ext.EAjaxUpload.EAjaxUpload',
			array(
			        'id'=>'uploadFile',
			        'config'=>array(
			               'action'=>Yii::app()->createUrl('/teach/knowledgepoint/importknowledgepoint'),
			               'allowedExtensions'=>array("xls","xlsx"),
			               'sizeLimit'=>10*1024*1024,// maximum file size in bytes
			               'onComplete'=>"js:function(id, fileName, responseJSON){  
										$.post('".Yii::app()->createUrl('teach/knowledgepoint/loadknowledgepoint')."&fname='+responseJSON.filename, { fname:responseJSON.filename }, function(data){
																$('#loadedlecinfo').html(data);
																$('#subtitle').html('请您仔细确认导入的知识点信息。');
																$('#loadkpinfo').fadeIn(1000);
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
<?php echo CHtml::ajaxButton ("确认导入知识点信息",
                              CController::createUrl('/teach/knowledgepoint/'), 
                              array('update' => '#loadkpinfo',
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
<?php
echo "科目: ";
echo CHtml::dropDownList( 'list_course','', $list_course ,
	array(
		'empty'=>'请选择一门课程',
		//'onchange' => 'js:alert( $("#list_course").val() )',
		/*'ajax' => array(
			'type'=>'POST',
			'url'=>CController::createUrl('knowledgepoint/FilterKnowledgePoint'), 
			'update'=>'#city_id', //selector to update
			)*/
	 )
); 
echo " 年级:";
echo CHtml::dropDownList( 'list_grade' , '' , $list_grade ,
		array(
		//'onchange' => 'js:alert( $("#list_course").val() )',
		'ajax' => array(
			'type'=>'POST',
			'url'=>CController::createUrl('index&school_id=1'),
			'data' => array('course'=>'js:$("#list_course").val()',
				'grade'=>'js:$("#list_grade").val()',
			),
			'update'=>'#knowledge-point-id', //selector to update
		),
		'empty'=>'全部',
) );
?> 
<div id="loadkpinfo" style="display:none">
</div>
<a href="#fancydata" class="fancylink" id="loadinghover" style="display:none">&nbsp;</a>
<div style="display:none">
	<div id="fancydata">
		<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif" />
		<p>文件正在上传中.................</p>
	</div>
</div>
<?php
$this->renderPartial( '_form_showkp' , array('dataProvider' => $dataProvider) );
$this->renderPartial( '_form_addkp' , array('kp_model' => $kp_model) ); 
?>
