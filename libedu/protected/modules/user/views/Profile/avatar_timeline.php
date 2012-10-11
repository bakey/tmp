<?php
	$cdate = substr($cnews->create_time,0,10);
	if($cdate != Yii::app()->user->previousNewsDate){
		if(Yii::app()->user->previousNewsDate!='1986-01-01'){
			echo '</div>';
		}
		echo '<div class="singleDayContainer">';
	}
?>

<div class="timeline_item" <?php if($cdate != Yii::app()->user->previousNewsDate) echo 'rel="1st"'; ?>>
	<h5><a href="<?php echo Yii::app()->createUrl('/user/profile/view',array('id'=>$cusr->id)); ?>"><?php if(Yii::app()->user->id = $cusr->id){ echo '我';}else{ echo $cusr->user_profile->real_name;} ?></a>：于<?php echo $cnews->create_time;?>更新了头像：</h5>
	<blockquote><?php echo CHtml::image(Yii::app()->request->baseUrl.'/'.Yii::app()->params['uploadFolder'].'/'.$cusr->id.'/avatar/'.$cnews->content,'alt',array('width'=>64,'height'=>64))?></blockquote>
</div>

<?php
	$cdate = substr($cnews->create_time,0,10);
	Yii::app()->user->setState('previousNewsDate', $cdate);
?>