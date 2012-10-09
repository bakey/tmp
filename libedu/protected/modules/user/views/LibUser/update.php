<?php
/* @var $this UserController */
/* @var $model User */

?>

<h1>修改密码</h1>
<?php 
if($msg == 0) {
	echo "
		<script type=\"text/javascript\">
			$.notification ( 
			    {
			        title:      '您输入的旧密码不正确!',
			        content:    '请您输入正确的密码'
			    }
			);
		</script>
	";
}else if($msg == -2){
	echo "
		<script type=\"text/javascript\">
			$.notification ( 
			    {
			        title:      '新密码与确认新密码不相同!',
			        content:    '请您确保两次输入的新密码一致。'
			    }
			);
		</script>
	";
}else if($msg == 1){
	echo "
		<script type=\"text/javascript\">
			$('#overlays .modal').fadeOut();
			$('#overlays').removeClass();
			$(document).unbind('keyup');
			$('#overlays .modal').remove();	
			$.notification ( 
			    {
			        title:      '密码修改成功!',
			        content:    '请您下次登录时使用新的密码。'
			    }
			);
		</script>
	";
}
?>

<?php echo $this->renderPartial('_formChangePassword', array('model'=>$model)); ?>

