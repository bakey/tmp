<?php
/* @var $this UserController */
/* @var $model User */

?>

<h1>重置密码</h1>
<?php if($msg == 0) {
	echo '<p>您输入的旧密码错误</p>';
}else if($msg == -2){
echo '<p>您确定您两次输入的新密码相同</p>';
}else if($msg == 1){
echo '<p>密码修改成功</p>';
}
?>

<?php echo $this->renderPartial('_formResetPassword', array('model'=>$model)); ?>