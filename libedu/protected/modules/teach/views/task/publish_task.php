<?php
$this->breadcrumbs=array(
		'测验管理'=>array('index'),
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
							'name'=>'accepter',
							'type'=>'raw',
					),
			),
	));
}
?>
