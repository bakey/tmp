<?php
/* @var $this LibController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'用户中心',
);

?>

<h1>您的账户还未激活</h1>

<h3>当您注册完成之后，我们已经给您的邮箱<?php echo $uemail;?>发送了一封激活确认信。请您再次检查您的收件箱，确保我们发送的邮件不在垃圾邮件箱内，打开邮件，点击邮件内的激活链接完成账户激活。如果您确认您没有收到激活邮件，请您点击<a href="<?php echo Yii::app()->createUrl('/user/libuser/resendactivationcode'); ?>">重新发送激活确认信</a>。</h3>