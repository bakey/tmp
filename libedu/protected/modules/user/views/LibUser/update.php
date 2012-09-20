<?php
/* @var $this UserController */
/* @var $model User */

?>

<h1>修改密码</h1>
<?php if($msg == 1) echo '<p>您输入的旧密码错误</p>'; ?>

<?php echo $this->renderPartial('_formChangePassword', array('model'=>$model)); ?>