<?php
/* @var $this LibController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'用户控制面板',
);

?>

<h1>用户激活</h1>

<p>
	<?php 
		echo $msg;
		if($result){
			echo ' 五秒钟后页面将自动跳转到首页，或者您可以<a href="'.$this->createUrl('/site/index').'">直接跳转</a>。';
		}else{
			echo ' 点击<a href="'.$this->createUrl('/user/libuser/resendactivationcode').'">重新发送</a>，系统将重新为您发送一封激活邮件，请点击邮件中的链接激活您的帐户。';
		}
	?>
</p>