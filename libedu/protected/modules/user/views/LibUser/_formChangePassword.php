<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="form" id="myform">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'libuser-form',
	'enableAjaxValidation'=>true,
	'htmlOptions'=>array('id'=>'changepwdform'),
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<p>
		<?php echo $form->labelEx($model,'oldpassword'); ?>
		<?php echo $form->passwordField($model,'oldpassword',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'oldpassword'); ?>
	</p>
	<p>
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'password'); ?>
	</p>
	<p>
		<?php echo $form->labelEx($model,'repeatpassword'); ?>
		<?php echo $form->passwordField($model,'repeatpassword',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'repeatpassword'); ?>
	</p>
	<p>
		<button class="sugar col_3" onclick="send()"><span>修改密码</span></button>
		<button class="sugar col_3" onclick="closemodal()"><span>取消</span></button>
	</p>

<?php $this->endWidget(); ?>
</div><!-- form -->

<script type="text/javascript">
	$('#LibUser_password').val("");
	$('#LibUser_repeatpassword').val("");

	function closemodal(){
			$('#overlays .modal').fadeOut(80);
			$('#overlays').removeClass();
			$(document).unbind('keyup');	
	}

	function send(){
		var data1=$("#changepwdform").serialize();
		$.ajax({
	    type: 'POST',
	    url: '<?php echo Yii::app()->createUrl("/user/libuser/changepassword",array("id"=>Yii::app()->user->id)); ?>',
	    data:data1,
	    success:function(data){
	                $('#overlays .modal .wrapper').html(data);
	              },
	    error: function(data) { // if error occured
	         alert("Error occured.please try again");
	    },
	    dataType:'html'
	  });
	 
	}

</script>