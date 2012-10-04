<?php
/* @var $this StatisticsController */

$this->breadcrumbs=array(
	'统计',
);
?>
<h1>我发布的测试</h1>
<?php 
$this->widget('zii.widgets.CListView', array(
		'dataProvider' => $teacher_index_data,
		'itemView'     => '_view_task_stat',
));
?>