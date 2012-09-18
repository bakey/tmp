<?php
/* @var $this CoursePostController */
/* @var $model CoursePost */

$this->breadcrumbs=array(
	'Course Posts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CoursePost', 'url'=>array('index')),
	array('label'=>'Manage CoursePost', 'url'=>array('admin')),
);
?>

<h1>Create CoursePost</h1>

<?php echo $this->renderPartial('_edit_form', array('model'=>$model)); ?>


