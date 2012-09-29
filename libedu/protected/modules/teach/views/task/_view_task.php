<div class="well">

	<b><?php
		 $item_model = Item::model()->findByPk( $data['item'] );
		 echo CHtml::encode('关联章节') . ":"; 
		 echo CHtml::encode($item_model->content);
	?></b>
	<br />

	<b><?php echo CHtml::encode('测验名'); ?>:</b>
	<?php
		if ( Yii::app()->user->urole == Yii::app()->params['user_role_teacher'] ) {
//老师直接浏览试卷
		 	echo CHtml::link( CHtml::encode($data['name']) , array('view', 'id'=>$data['id']));
		}
		else {
//学生根据情况，未完成的试卷就直接开始答卷。已完成的就浏览完成后的试卷即可
			if ( $data['status'] == TaskRecord::TASK_STATUS_UNFINISHED ) {
				echo CHtml::link( CHtml::encode($data['name']) , array('participatetask', 'task_id'=>$data['id']) , array('target'=>'_blank') );
			}else if ( $data['status'] == TaskRecord::TASK_STATUS_FINISHED ) {
				echo CHtml::link( CHtml::encode($data['name']) , array('showfinishtask', 'task_id'=>$data['id']) , array('target'=>'_blank'));
			} 
		}
	?>
	<br />
	
	<b><?php echo CHtml::encode('创建时间'); ?>:</b>
	<?php echo CHtml::encode($data['create_time']); ?>
	<br />

	<b><?php echo CHtml::encode('发布者'); ?>:</b>
	<?php
		$user_model = LibUser::model()->findByPk( $data['author']); 
		$author_name = $user_model->user_profile->real_name;
		echo CHtml::encode($author_name); 
	?>
	<br />

</div>
