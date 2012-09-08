<?php
/* @var $this LibClassApplyController */
/* @var $model LibClassApply */

$this->breadcrumbs=array(
	'Lib Class Applies'=>array('index'),
	'Create',
);
?>

<h1>申请加入班级</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'classlist'=>$classlist)); ?>