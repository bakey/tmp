<?php
$this->breadcrumbs=array(
	'我的测验',
);
?>
<?php
$this->menu=array(
	array('label'=>'创建测验', 'url'=>array('create')),
	array('label'=>'管理测验', 'url'=>array('admin')),
);
echo( Yii::app()->user->real_name . "老师 ，以下是你最近出的试卷");
$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProvider,
		'itemView'=>'_view_teacher_task',
));
?>