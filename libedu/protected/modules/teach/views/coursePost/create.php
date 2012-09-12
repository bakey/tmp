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

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

<?php 
$url = 'course/ajaxFillTree&edition_id=' . $edition->id;
$this->widget(
	    'CTreeView',
		array(
            'animated'=>'fast', //quick animation
            'collapsed' => false,
            'url' => array( $url ), 
		)
);
?>
