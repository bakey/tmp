<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Create',
);

?>

<h1>用户注册</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>