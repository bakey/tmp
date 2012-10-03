<?php
/* @var $this LibClassController */
/* @var $data LibClass */
?>

<?php
 $this->widget( 'bootstrap.widgets.TbGridView' , array(
 			'type'=>'striped bordered condensed',
   			'dataProvider'=>$classcourse,
   			'columns'=>array(
   				array(
   					'name'=>'教师',
   					'value'=>'$data->user_info->user_profile->real_name',
   				),
   				array(
   					'name'=>'课程',
   					'value'=>'$data->course_info->name',
   				),
   				array(
   					'name'=>'教材',
   					'value'=>'$data->course_info->edition->name',
   				),
   				array(
				   	'class'=>'CLinkColumn',
				    'header'=>'操作',
				    'labelExpression'=>'"取消关联"',
				    'urlExpression'=>'"'.Yii::app()->createUrl('/').'"',
   				),
   			),
 		));
?>