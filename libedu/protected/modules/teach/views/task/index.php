<?php
$this->breadcrumbs=array(
	'Tasks',
);
?>
<?php
$this->menu=array(
	array('label'=>'创建测验', 'url'=>array('create')),
	array('label'=>'管理测验', 'url'=>array('admin')),
);
?>
<h1>
<?php
if ( Yii::app()->user->urole == Yii::app()->params['user_role_teacher'] ) {
	echo( Yii::app()->user->real_name . "老师 ，以下是你最近出的试卷");
}else if ( Yii::app()->user->urole == Yii::app()->params['user_role_student'] ){
	echo( Yii::app()->user->real_name . " 同学，以下是你的试卷");
}
?>
</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view_task',
)); ?>
