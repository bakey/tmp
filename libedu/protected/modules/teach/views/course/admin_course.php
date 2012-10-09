<?php
$this->breadcrumbs=array(
	'Courses',
);

$this->menu=array(
	array('label'=>'Create Course', 'url'=>array('create')),
	array('label'=>'Manage Course', 'url'=>array('admin')),
);
?>

<h1>Courses</h1>

<?php
if($courseModel!==null)
{
	foreach($courseModel as $course)
	{
		if(!isset($grade[$course->grade]))
			$grade[$course->grade]=0;
		$grade[$course->grade]++;
	}
	
	foreach($grade as $key=>$value)
	{
		echo '下面是'.$key.'年级的所有班级课程';
		echo '<br>';

		$criteria=new CDbCriteria;
		$criteria->compare('grade',$key);
		$criteria->compare('school_id',$schoolid);
		$criteria->with='edition';
		$courses=Course::model()->findAll($criteria);
		$this->widget('zii.widgets.grid.CGridView', array(
			'dataProvider'=>new CArrayDataProvider($courses),
			'emptyText'=>'没有相关课程',
			'columns'=>array(
				array('name'=>$key.'年级课程','value'=>'$data->name','type'=>'raw'),			    
				array('name'=>'教材','value'=>array($this,'showCourseEdition'),'type'=>'raw'),
				),
				));
	}
}
?>

<?php 

$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
		'id'=>'mydialog',
		'actionPrefix'=>'index',
		'options'=>array(
			'title'=>'添加关联教材',
			'autoOpen'=>false,
			'modal'=>true,
				)
				));

$this->renderPartial('allEditions');
$this->endWidget('zii.widgets.jui.CJuiDialog');
	
?>