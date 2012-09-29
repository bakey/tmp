<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
    'links'=>array('用户中心'=>'#', '用户激活'=>'#','激活结果'),
)); ?>

<div class="page-header">
  <h2>激活 <small>激活结果</small></h2>
</div>

<p>
	<?php 
		echo '<div class="well"><p>'.$msg;
		if($result){
			echo ' 五秒钟后页面将自动跳转到首页，或者您可以<a href="'.$this->createUrl('/site/index').'">直接跳转</a>。</p></div>';
		}else{
			echo ' 点击<a href="'.$this->createUrl('/user/libuser/resendactivationcode').'">重新发送</a>，系统将重新为您发送一封激活邮件，请点击邮件中的链接激活您的帐户。</p></div>';
		}
	?>
</p>