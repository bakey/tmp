<div class="well">

	<b><?php
		 $item_model = Item::model()->findByPk( $data['item'] );
		 echo CHtml::encode('关联章节') . ":"; 
		 echo CHtml::encode($item_model->content);
	?></b>
	<br />

	<b><?php echo CHtml::encode('测验名'); ?>:</b>
	<?php
	 	echo CHtml::link( CHtml::encode($data['name']) , array('view', 'id'=>$data['id']));
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
	<b><?php
			//老师展示试卷状态 
			echo CHtml::encode('试卷状态:');
			if ( $data['status'] == Task::STATUS_DRAFT ) {
				echo "试卷未发布";
			} else {
				$msg = sprintf("试卷已经发布给(%d)名学生 , 已经有(%d)名学生完成" , $data['total_accept_task_stu_cnt'] , $data['finish_task_stu_cnt']);
				echo $msg;
			}
	?></b>
	

</div>
