<div class="container">
	<div class="col_2">
		<img src="<?php echo Yii::app()->request->baseUrl.'/'.Yii::app()->params['uploadFolder'].'/'.$data->owner_info->id.'/avatar/'.$data->owner_info->user_profile->avatar; ?>" class="img-polaroid">
	</div>
	<div class="col_10">
		<div class="col_12 roundbordered tinytinyallpadding">

				<p><?php echo CHtml::encode($data->owner_info->user_profile->real_name); ?> 于 <?php echo CHtml::encode($data->create_time); ?> <?php 
					   $anstype = ''; 
						if($data->type == 1){
							$anstype= '追问';
						}else if($data->type == 2){
							$anstype= '回答';
						}else if($data->type == 0){
							$anstype = '评论';
						}
						echo $anstype;
					?>道：
				</p>	
				<div class="col_12 dotbottom">
					<blockquote>
						<?php echo $data->details;?>
					</blockquote>
				</div>



				<div class="col_2 offset_8">
					<p>收藏</p>
				</div>
				<?php
					if(($data->type == 2) and ($data->level == 0)){
						echo '<div class="col_2">
					<p> ';
						echo CHtml::link('追问'.'(0)','javascript:void(0);',
							array(
							'onclick'=>CHtml::ajax( array('url'=>Yii::app()->createUrl('/teach/question/zwtoanswer',array('qid'=>$data->id,'type'=>1)),
							'update'=>'#subanswer'.$data->id,'success'=>'js:function(data){$("#subanswer'.$data->id.'").html(data);$("#subanswer'.$data->id.'").fadeIn();}'
		)),'id'=>'subzwtrigger'.$data->id,

							));		
						echo '</p>
				</div>';
					}
				?>
				<?php
				
					if(($data->type == 1) and ($data->level == 0)){
						echo '<div class="col_2">
					<p> ';
						echo CHtml::link('回答'.'(0)','javascript:void(0);',
							array(
							'onclick'=>CHtml::ajax( array('url'=>Yii::app()->createUrl('/teach/question/zwtoanswer',array('qid'=>$data->id,'type'=>2)),
							'update'=>'#subanswer'.$data->id,'success'=>'js:function(data){$("#subanswer'.$data->id.'").html(data);$("#subanswer'.$data->id.'").fadeIn();}'
		)),'id'=>'subanswertrigger'.$data->id,

							));
						echo '</p>
				</div>';
					}else{
						if($data->level != 0){
							echo '<div class="col_2">
					<p> ';
						echo CHtml::link('回答'.'(0)','javascript:void(0);',
							array(
							'onclick'=>CHtml::ajax( array('url'=>Yii::app()->createUrl('/teach/question/zwtoanswer',array('qid'=>$data->id,'type'=>2)),
							'update'=>'#subanswer'.$data->id,'success'=>'js:function(data){$("#subanswer'.$data->id.'").html(data);$("#subanswer'.$data->id.'").fadeIn();}'
		)),'id'=>'subanswertrigger'.$data->id,

							));
						echo '</p>
				</div>';
						}
					}
			?>


			<div class="carton roundbordered nobackground tinyallpadding col_11" id="subanswer<?php echo $data->id ?>" style="display:none;">
			</div>
		</div>
	</div>
	
</div>