<div class="user_profile_panel" style="border:1px solid #16a9f7;padding:5px; margin-right:30px; margin-bottom:20px;">
	<?php echo CHtml::image(Yii::app()->request->baseUrl.'/'.Yii::app()->params['uploadFolder'].'/'.$cusr->id.'/avatar/'.$cusr->user_profile->avatar,'alt',array('width'=>64,'height'=>64,'style'=>'border:2px solid #16a9f7;float:left;'))?>
	<ul style="float:left; width:70px;">
		<li><?php echo $cusr->user_profile->real_name;?></li>
		<li>还可以放</li>
		<li>用户的其他信息……</li>
	</ul>
	<div style="clear:both">&nbsp;</div>
</div>