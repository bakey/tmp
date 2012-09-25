<?php
/* @var $this LibClassController */
/* @var $model LibClass */
/*
$this->breadcrumbs=array(
	'课程管理'=>array('/teach/course/admin'),
	'学生管理',
);
*/
$this->menu=array(
	array('label'=>'List LibClass', 'url'=>array('index')),
	array('label'=>'Create LibClass', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('lib-class-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>班级管理</h1>

<?php /*echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); */?>
<div class="search-form" style="display:none">
<?php /*$this->renderPartial('_search',array(
	'model'=>$model,
));*/ 
?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.CListView', array(
	'id'=>'lib-class-grid',
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
