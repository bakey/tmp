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
<?php
	if ( Yii::app()->user->urole == Yii::app()->params['user_role_teacher'] ) {
		echo( Yii::app()->user->real_name . "老师 ，以下是你最近出的试卷");
		$this->widget('zii.widgets.CListView', array(
				'dataProvider'=>$dataProvider,
				'itemView'=>'_view_task',
		));
	}
	else if ( Yii::app()->user->urole == Yii::app()->params['user_role_student'] )
	{
		echo( "<h1>" . Yii::app()->user->real_name . " 同学，以下是你未完成的试卷</h1>");
		$this->widget('zii.widgets.CListView', array(
			'dataProvider'=>$unfinished_task_data,
			'itemView'=>'_view_task',
		));
		echo( "<h1>" . Yii::app()->user->real_name . " 同学，以下是你已完成的试卷</h1>");
		$this->widget('zii.widgets.CListView', array(
			'dataProvider'=>$finished_task_data,
			'itemView'=>'_view_task',
		));
	}
?>

<?php
/* $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view_task',
));*/
 ?>
