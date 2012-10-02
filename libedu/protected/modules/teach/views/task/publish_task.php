<?php
$this->breadcrumbs=array(
		'测验管理'=>array('index'),
		'测验具体情况'
);

if ( count($task_record_model->getData()) > 0 ){
	if ( isset($new_record) && $new_record ) {
		echo "<h4>本次测试已经发布给如下学生</h4>";
	}else {
		echo("<h4>此次测试已经发布，不需再次发布</h4>");
	}
	$this->widget('bootstrap.widgets.TbGridView', array(
			'dataProvider'=>$task_record_model,
			'type' =>'bordered striped',
			'columns'=>array(
					array(
							'name'=>'task',
							'type'=>'raw',
					),
					array(
							'name'=>'测试学生',
							'value'=>'$data->accepter',
							'type'=>'raw',
					),
					array(
							'name'=>'是否完成',
							'value'=>'$data->status',
							'type'=>'raw',
					),
			),
	));
}
?>
