<?php
/* @var $this QuestionController */
/* @var $data Question */
?>

<div class="row-fluid">
	<div class="span1">
		<img src="<?php echo Yii::app()->request->baseUrl.'/'.Yii::app()->params['uploadFolder'].'/'.$data->owner_info->id.'/avatar/'.$data->owner_info->user_profile->avatar; ?>" class="img-polaroid">
	</div>
	<div class="span11">
		<div class="well">
				<p><?php echo CHtml::encode($data->owner_info->user_profile->real_name); ?> 于 <?php echo CHtml::encode($data->create_time); ?> 提问</p>	
				<blockquote><?php echo $data->details; ?></blockquote>  
				
				<p>关联章节：
					<?php $this->widget('bootstrap.widgets.TbLabel', array(
						'type'=>'info', // 'success', 'warning', 'important', 'info' or 'inverse'
						'label'=>$data->item_info->content,
					)); ?></p>

				<h6><a class="btn" href="<?php echo Yii::app()->createUrl('/teach/question/answer',array('qid'=>$data->id)); ?>">回答</a> <a class="btn" href="<?php echo Yii::app()->createUrl('/teach/question/view',array('id'=>$data->id)); ?>">查看</a></h6>

			<div class="well" id="sanswer<?php echo $data->id ?>" style="display:none;margin-left:40px;">
				</div>
		</div>
	</div>
	
</div>