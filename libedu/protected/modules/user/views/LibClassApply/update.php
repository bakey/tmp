<?php
/* @var $this LibClassApplyController */
/* @var $model LibClassApply */

$this->breadcrumbs=array(
	'Lib Class Applies'=>array('index'),
	$model->applicant=>array('view','id'=>$model->applicant),
	'Update',
);

$this->menu=array(
	array('label'=>'List LibClassApply', 'url'=>array('index')),
	array('label'=>'Create LibClassApply', 'url'=>array('create')),
	array('label'=>'View LibClassApply', 'url'=>array('view', 'id'=>$model->applicant)),
	array('label'=>'Manage LibClassApply', 'url'=>array('admin')),
);
?>

<h1>Update LibClassApply <?php echo $model->applicant; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>