<h4>本次测试的题目</h4>
<div class="well">
<?php
 $this->widget('bootstrap.widgets.TbGridView', array(
		'dataProvider'=>$problem_data,
 		'type' =>'bordered striped',
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
 ?>
 </div>
 <h4>本次考试将会发布给以下学生,默认为本课程下的学生</h4>
 <?php
 $url = Yii::app()->request->hostInfo . Yii::app()->createUrl('teach/task/publishtask&task_id=' . $task_id );

 echo CHtml::beginForm( $url , 'POST' );
 $this->renderPartial( '_form_assign_task_student' , array(
						'dataProvider' => $student_data,
					  ) );
 
 echo CHtml::submitButton('确认发布测试', array(
		'name'=>'confirm_publish',
 		//'onClick'=>'window.location.href="' . $url . '"', 
 		) ) ;
 echo CHtml::endForm();
?>