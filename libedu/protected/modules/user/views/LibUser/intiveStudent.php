<?php
/* @var $this LibController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'用户中心',
);

?>

<h1>邀请教师加入系统</h1>

<?php 
	if(isset($msg)){
		echo '<h3>'.$msg.'</h3>';
	}
?>

<div class="form">
<?php echo $form; ?>
</div>
