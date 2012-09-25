<div class="timeline_item">
	<h5><a href="<?php echo Yii::app()->createUrl('/user/profile/view',array('id'=>$cusr->id)); ?>"><?php if(Yii::app()->user->id = $cusr->id){ echo '我';}else{ echo $cusr->user_profile->real_name;} ?></a>：于<?php echo $cnews->create_time;?>更新了头像：</h5>
	<blockquote><?php echo CHtml::image(Yii::app()->request->baseUrl.'/'.Yii::app()->params['uploadFolder'].'/'.$cusr->id.'/avatar/'.$cnews->content,'alt',array('width'=>64,'height'=>64))?></blockquote>
</div>