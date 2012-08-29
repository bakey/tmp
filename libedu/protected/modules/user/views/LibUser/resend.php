<?php
/* @var $this LibController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'用户中心',
);

?>

<h1>重新发送激活邮件</h1>

<?php 
	if(isset($msg)){
		echo '<h3>'.$msg.'</h3>';
	}
?>

<div class="form">
<?php echo $form; ?>
</div>
