<?php
/* @var $this LibClassController */
/* @var $model LibClass */

$this->breadcrumbs=array(
	'Lib Classes'=>array('index'),
	'Create',
);
?>

<h1>创建班级</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'tinfo'=>$tinfo)); ?>