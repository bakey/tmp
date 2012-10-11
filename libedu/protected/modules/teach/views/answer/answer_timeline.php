<?php
	$cdate = substr($cans->create_time,0,10);
	if($cdate != Yii::app()->user->previousNewsDate){
		if(Yii::app()->user->previousNewsDate!='1986-01-01'){
			echo '</div>';
		}
		echo '<div class="singleDayContainer">';
	}
?>

<div class="timeline_item" <?php if($cdate != Yii::app()->user->previousNewsDate) echo 'rel="1st"'; ?>>
	<h5><a href="<?php echo Yii::app()->createUrl('/user/profile/view',array('id'=>$cusr->id)); ?>">
		<?php if(Yii::app()->user->id == $cusr->id){
		 			echo '我';
		 	  }else{ 
		 	  		echo $cusr->user_profile->real_name;
		 	  } ?></a>：于<?php echo $cans->create_time;?>回答了问题：<a href="<?php echo Yii::app()->createUrl('/teach/question/view',array('id'=>$cans->question_info->id)); ?>"><?php echo strip_tags($cans->question_info->details);?></a></h5>
	<blockquote><?php echo $cans->details;?></blockquote>
</div>

<?php
	$cdate = substr($cans->create_time,0,10);
	Yii::app()->user->setState('previousNewsDate', $cdate);
?>