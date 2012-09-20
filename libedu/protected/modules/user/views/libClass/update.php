<?php
/* @var $this LibClassController */
/* @var $model LibClass */

$this->breadcrumbs=array(
	'Lib Classes'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LibClass', 'url'=>array('index')),
	array('label'=>'Create LibClass', 'url'=>array('create')),
	array('label'=>'View LibClass', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage LibClass', 'url'=>array('admin')),
);
?>

<h1>编辑班级： <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'tinfo'=>$tinfo)); ?>