<?php
/* @var $this QuestionController */
/* @var $data Question */
?>

<div class="container">
	<div class="col_2 qavatar">
		<p><img src="<?php echo Yii::app()->request->baseUrl.'/'.Yii::app()->params['uploadFolder'].'/'.$data->owner_info->id.'/avatar/'.$data->owner_info->user_profile->avatar; ?>" class="img-polaroid"></p>
		<p><span><?php echo CHtml::encode($data->owner_info->user_profile->real_name); ?></span></p>
	</div>
	<div class="col_10">
		<div class="carton roundbordered tinyallpadding">  
			<h2>问题章节：<?php echo $data->item_info->content; ?></h2>
			<div class="container nobottommargin  questionop">
				<div class="col_12 dotbottom">
					<blockquote>
						<?php echo $data->details; ?>
					</blockquote>
				</div>
				
				<div class="col_5">
					<p>提问于 <?php echo CHtml::encode($data->create_time); ?></p>	
				</div>
				<div class="col_1 offset_3">
					<p>收藏</p>
				</div>
				<div class="col_2">
					<p> <?php
				echo CHtml::ajaxLink('追问',Yii::app()->createUrl('/teach/question/getallsubelement',array('qid'=>$data->id,'type'=>1)),array('update'=>'#answer'.$data->id,'success'=>'js:function(data){$("#answer'.$data->id.'").html(data);$("#answer'.$data->id.'").fadeIn();}'),array('rel'=>'external','href'=>'javascript:return false;'));?>(2)</p>
				</div>
				<div class="col_2">
					<p> <?php
				echo CHtml::ajaxLink('回答',Yii::app()->createUrl('/teach/question/getallsubelement',array('qid'=>$data->id,'type'=>2)),array('update'=>'#answer'.$data->id,'success'=>'js:function(data){$("#answer'.$data->id.'").html(data);$("#answer'.$data->id.'").fadeIn();}'),array('rel'=>'external','href'=>'javascript:return false;')); 
			?>(2)</p>
				</div>
			</div>
			<div class="carton roundbordered nobackground tinyallpadding" id="answer<?php echo $data->id ?>" style="display:none;">
			</div>
		</div>
	</div>
	
</div>