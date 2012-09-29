<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
    'links'=>array('首页'=>'#', '行政管理'=>'#','教师管理'=>'#','邀请教师加入'),
)); ?>

<div class="page-header">
  <h2>教师管理 <small>邀请教师加入</small></h2>
</div>


<?php 
	if(isset($msg)){
		echo '<div class="alert alert-info">
  <button type="button" class="close" data-dismiss="alert">×</button><h5>'.$msg.'</h5></div>';
	}
?>

<div class="form">
<?php 
	echo $form; 
	?>
</div>
