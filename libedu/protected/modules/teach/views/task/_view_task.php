<div class="well">

	<b><?php
		 $item_model = Item::model()->findByPk( $data->item );
		 echo CHtml::encode($data->getAttributeLabel('关联章节')) . ":"; 
		 echo CHtml::encode($item_model->content);
	?></b>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('测验名')); ?>:</b>
	<?php
		if ( Yii::app()->user->urole == Yii::app()->params['user_role_teacher'] ) {
		 	echo CHtml::link( CHtml::encode($data->name) , array('view', 'id'=>$data->id));
		}
		else {
			echo CHtml::link( CHtml::encode($data->name) , array('participatetask', 'task_id'=>$data->id));
		}
	?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('创建时间')); ?>:</b>
	<?php echo CHtml::encode($data->create_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('发布者')); ?>:</b>
	<?php
		$user_model = LibUser::model()->findByPk( $data->author); 
		$author_name = $user_model->user_profile->real_name;
		echo CHtml::encode($author_name); 
	?>
	<br />

</div>
