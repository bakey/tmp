<h4>本次测试的题目</h4>
<?php
 $this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$problem_data,
		'columns'=>array(
				array(
						'name'=>'id',
						'type'=>'raw',
				),
				array(
						'name'=>'content',
						'type'=>'raw',
				),
		),
));
 $url = Yii::app()->request->hostInfo . Yii::app()->createUrl('teach/task/publishtask&task_id=' . $task_id );
 echo CHtml::button('发布测试', array(
 		'onClick'=>'window.location.href="' . $url . '"', 
 		) ) ;
?>