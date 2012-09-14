<?php
/* @var $this UserController */
/* @var $model User */

Yii::app()->clientScript->registerCoreScript('jquery');
?>

<?php $this->widget('application.extensions.fancybox.EFancyBox', array(
        'target'=>'a.fancylink',
        'config'=>array('minWidth'=>'300px','minHeight'=>'100px','closeBtn'=>false),));  
?>  

<a href="#fancydata" class="fancylink" id="loadinghover" style="display:none">&nbsp;</a>
<div style="display:none">
	<div id="fancydata">
		<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif" />
		<p id="fancycontent">AJAX is WORKING.................</p>
	</div>
</div>

<h1>邀请教师加入</h1>

<?php 	
		echo CHtml::label('请您要邀请的用户的电子邮箱地址','mailinput');
	    echo CHtml::textField('mailinput',null,array('id'=>'emailinput'));
	    echo CHtml::button('加入',array('id'=>'addBtn'));
	    echo CHtml::button('删除',array('id'=>'deleteBtn','disabled'=>'disabled'));
		echo CHtml::dropDownList('inviteemaillist','1',array(),array('size'=>15,'style'=>'min-width:500px;display:block;clear:both;'));
		echo CHtml::button('发送邀请',array('id'=>'submitBtn','onClick'=>'$(".fancylink").click()'));
?>


<script type="text/javascript">
	
	function doRemoveEmail(){
		$('.emailinlist[value="'+$('#deleteBtn').attr('rel')+'"]').remove();
	}

	function doValidateInput(){
		var pattern = /^[a-zA-Z0-9_\.]+@[a-zA-Z0-9-]+[\.a-zA-Z]+$/;
		if(!pattern.test($('#emailinput').val())){
			$('#fancydata').html('请输入正确的邮箱地址！');
			$('#fancydata').append('<button onClick="$.fancybox.close();">关闭</button>')
			$('.fancylink').click();            	
	    }else{
	       	$('#inviteemaillist').append('<option class="emailinlist" value="'+$('#emailinput').val()+'">'+$('#emailinput').val()+'</option>');
	       	$('.emailinlist').click(function(e){$('#deleteBtn').removeAttr('disabled');$('#deleteBtn').attr('rel',$(e.target).val())});
	       	$('#emailinput').val('');
	    }
	}
	$('#emailinput').keyup(function(e) {
	    var keycode = (e.keyCode ? e.keyCode : e.which);
        if (keycode == '13') {
           doValidateInput();
        }
	});

	$('#addBtn').click(function(){doValidateInput();});
	$('#deleteBtn').click(function(){doRemoveEmail();});

</script>