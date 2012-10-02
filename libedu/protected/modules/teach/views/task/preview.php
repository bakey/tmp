<h4>本次测试的题目</h4>
<div class="well">
<?php
 $this->widget('bootstrap.widgets.TbGridView', array(
		'dataProvider'=>$problem_data,
 		'type' =>'bordered striped',
		'columns'=>array(
				array(
						'name'=>'题目id',
						'value' => '$data["id"]',
						'type'=>'raw',
				),
				array(
						//'name'=>'content',
						'name'=>'题目内容',
						'value' => '$data["content"]',
						'type'=>'html',
				),
				array(
						'name'=>'题目难度',
						'value' => '$data["difficulty"]',
						'type'=>'raw',
				),
				array(
						'name' => '题目类型',
						'value' => '$data["type"]',
						'type' => 'raw',
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
 		) ) ;
 echo CHtml::endForm();
?>