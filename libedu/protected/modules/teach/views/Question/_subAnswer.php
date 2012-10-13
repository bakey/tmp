<div class="container">
	<div class="col_2">
		<img src="<?php echo Yii::app()->request->baseUrl.'/'.Yii::app()->params['uploadFolder'].'/'.$data->owner_info->id.'/avatar/'.$data->owner_info->user_profile->avatar; ?>" class="img-polaroid">
	</div>
	<div class="col_10">
		<div class="well">
				<p>
					<?php 
					   $anstype = ''; 
						if($data->type == 1){
							$anstype= '追问';
						}else if($data->type == 2){
							$anstype= '回答';
						}else if($data->type == 0){
							$anstype = '评论';
						}
						echo $anstype;
					?></p>
				<p><?php echo CHtml::encode($data->owner_info->user_profile->real_name); ?> 于 <?php echo CHtml::encode($data->create_time); ?> 写道：
				</p>	
				<blockquote><?php echo $data->details; ?></blockquote>  


			<div class="well" id="answer<?php echo $data->id ?>" style="display:none;margin-left:40px;">
				</div>
		</div>
	</div>
	
</div>