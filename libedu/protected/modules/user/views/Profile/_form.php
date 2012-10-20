<?php
/* @var $this ProfileController */
/* @var $model Profile */
/* @var $form CActiveForm */
?>

    	<div class="container">
    		<div class="carton col_12">
    			<h3>修改头像</h3>

<div class="form well row">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'profile-modify-form',
	'enableAjaxValidation'=>false,
)); 
	//register js file
		$baseUrl = Yii::app()->baseUrl; 
		$cs = Yii::app()->getClientScript();
		$cs->scriptMap=array(
		        'jquery.js'=>false,
		);
		$cs->registerScriptFile($baseUrl.'/js/jquery.Jcrop.min.js');
		$cs->registerScriptFile($baseUrl.'/js/jquery.color.js');
		//$cs->registerCssFile($baseUrl.'/css/jcrop/jquery.Jcrop.min.css');
 
?>

	<?php echo $form->errorSummary($model); ?>
		
		<?php echo $form->labelEx($model,'avatar'); ?>
		<div class="span1" id="currentavatardiv">
		<?php 
		$avatarCode = ''; 
		if($model->avatar != 'default_avatar.jpg'){
			$avatarCode = CHtml::image(Yii::app()->request->baseUrl.'/'.Yii::app()->params['uploadFolder'].'/'.$model->user_info->id.'/avatar/'.$model->avatar,'alt',array('width'=>64,'height'=>64,'id'=>'currentAvatar','class'=>'img-polaroid'));
		}else{
			$avatarCode = CHtml::image(Yii::app()->request->baseUrl.'/images/'.$model->avatar,'alt',array('width'=>64,'height'=>64,'id'=>'currentAvatar','class'=>'img-polaroid'));
		}
		echo $avatarCode; ?>
		</div>
		<div class="span7 div-bordered" id="uploadavatardiv">
			<h5>上传新头像</h5>
			<div class="col_12">
		<?php
			$this->widget('ext.EAjaxUpload.EAjaxUpload',
			array(
			        'id'=>'juploadFile',
			        'config'=>array(

			               'action'=>Yii::app()->createUrl('user/profile/uploadavatar'),
			               'allowedExtensions'=>array("jpg","png","gif"),//array("jpg","jpeg","gif","exe","mov" and etc...
			               'sizeLimit'=>1*1024*1024,// maximum file size in bytes
			               //'minSizeLimit'=>10*1024*1024,// minimum file size in bytes
			               'onComplete'=>"js:function(id, fileName, responseJSON){  
			               					function showPreview(coords)
											{
												var rx = 100 / coords.w;
												var ry = 100 / coords.h;

												$('#preview').css({
													width: Math.round(rx * $('#currentAvatarImg').width()) + 'px',
													height: Math.round(ry * $('#currentAvatarImg').height()) + 'px',
													marginLeft: '-' + Math.round(rx * coords.x) + 'px',
													marginTop: '-' + Math.round(ry * coords.y) + 'px'
												});
											}
			               					$('.qq-uploader').fadeOut(300);
			               					$('#uploaded_avatar').html('<img id=\"currentAvatarImg\" src=\"".Yii::app()->request->baseUrl.'/'.Yii::app()->params['uploadFolder'].'/temp_upload/'."'+responseJSON.filename+'\" width=\"400px\"/><h4>头像预览</h4><div style=\"width:80px; height:80px; overflow:hidden;\"><img id=\"preview\" src=\"".Yii::app()->request->baseUrl.'/'.Yii::app()->params['uploadFolder'].'/temp_upload/'."'+responseJSON.filename+'\"/></div>');
			               					$('#uploaded_avatar').fadeIn(1000);
											$('#currentAvatarImg').Jcrop({
												onChange: showPreview,
												onSelect: showPreview,
												onDblClick: function(coords){
													$.post('".Yii::app()->createUrl('user/profile/cropavatar')."', { cx: coords.x, cy: coords.y, cw:coords.w, ch:coords.h, fname:responseJSON.filename }, function(data){
																if(data != 'fail'){
																	$('#uploaded_avatar').fadeOut(500);
																	$('#currentAvatar').attr('src',data);
																	$('.qq-uploader').fadeIn(300);
																	var fnamestr = data.toString();
																	var fnamearray = new Array();
																	fnamearray = fnamestr.split('/');
																	$('#Profile_avatar').attr('value',fnamearray[5]);
																}else{
																	alert('网络错误，请再双击一次保存您的新头像');
																}
														} );
												},
												aspectRatio: 1,
												 bgColor:     'black',
									            bgOpacity:   .4,
									            setSelect:   [ 100, 100, 64, 64 ],
											});
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
	</div>
		<div id="uploaded_avatar" style="display:none">
		</div>

		</div>
		<div style="clear:both">&nbsp;</div>
		<?php echo $form->hiddenField($model,'avatar',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'avatar'); ?>
		<div class="container">
					<div class="content">
						<button class="turkish col_4 offset_2"><span>修改个人信息</span></button>
					</div>
				</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
			</div>
	    </div>

	    <script type="text/javascript">
	    	$(document).unbind('tap');
	    </script>