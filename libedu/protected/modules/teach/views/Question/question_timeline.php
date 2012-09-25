<div class="timeline_item">
	<h5><a href="<?php echo Yii::app()->createUrl('/user/profile/view',array('id'=>$cusr->id)); ?>">
		<?php if(Yii::app()->user->id == $cusr->id){
		 			echo '我';
		 	  }else{ 
		 	  		echo $cusr->user_profile->real_name;
		 	  } ?></a>：于<?php echo $cquestion->create_time;?>提出了问题：</h5>
	<blockquote><?php echo $cquestion->details;?></blockquote>
	<p><a href="<?php echo Yii::app()->createUrl('/teach/question/view',array('id'=>$cquestion->id)); ?>">查看</a> | <a href="<?php echo Yii::app()->createUrl('/teach/question/answer',array('qid'=>$cquestion->id)); ?>">回答</a></p>
</div>