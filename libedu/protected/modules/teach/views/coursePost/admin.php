<?php
/* @var $this CoursePostController */
/* @var $model CoursePost */

$this->breadcrumbs=array(
	'Course Posts'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List CoursePost', 'url'=>array('index')),
	array('label'=>'Create CoursePost', 'url'=>array('create')),
);

?>

<h1>Manage Course Posts</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'course-post-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'post',
		'author',
		'item_id',
		'status',
		'create_time',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
