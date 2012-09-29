<?php
/* @var $this LibController */
/* @var $dataProvider CActiveDataProvider */

$this->widget('bootstrap.widgets.TbBreadcrumbs', array(
    'links'=>array('用户中心'=>'#', '用户激活'=>'#','重新发送激活邮件'),
)); ?>

<div class="page-header">
  <h2>激活 <small>重新发送激活邮件</small></h2>
</div>

<?php 
	if(isset($msg)){
		echo '<div class="alert alert-info">
  <button type="button" class="close" data-dismiss="alert">×</button><h5>
  '.$msg.'</h5></div>';
	}
?>

<div class="form">
<?php echo $form; ?>
</div>
