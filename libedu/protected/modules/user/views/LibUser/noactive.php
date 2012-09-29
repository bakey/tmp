<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
    'links'=>array('用户中心'=>'#', '用户激活'),
)); ?>

<div class="page-header">
  <h2>激活 <small>您的账户还未激活</small></h2>
</div>

<div class="well">
	<p>当您注册完成之后，我们已经给您的邮箱 <code><?php echo $uemail;?></code> 发送了一封激活确认信。请您再次检查您的收件箱，确保我们发送的邮件不在 <span class="badge badge-important"><i class="icon-trash icon-white"> </i> 垃圾邮件箱</span> 内，打开邮件，点击邮件内的激活链接完成账户激活。</p>
	<p>如果您确认您没有收到激活邮件，请您点击<a href="<?php echo Yii::app()->createUrl('/user/libuser/resendactivationcode'); ?>">重新发送激活确认信</a>。</p>
</div>