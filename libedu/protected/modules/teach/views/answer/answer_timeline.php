<div class="timeline_item">
	<h5><a href="<?php echo Yii::app()->createUrl('/user/profile/view',array('id'=>$cusr->id)); ?>">
		<?php if(Yii::app()->user->id == $cusr->id){
		 			echo '我';
		 	  }else{ 
		 	  		echo $cusr->user_profile->real_name;
		 	  } ?></a>：于<?php echo $cans->create_time;?>回答了问题：<a href="<?php echo Yii::app()->createUrl('/teach/question/view',array('id'=>$cans->question_info->id)); ?>"><?php echo strip_tags($cans->question_info->details);?></a></h5>
	<blockquote><?php echo $cans->details;?></blockquote>
</div>