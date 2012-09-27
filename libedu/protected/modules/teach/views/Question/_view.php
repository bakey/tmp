<?php
/* @var $this QuestionController */
/* @var $data Question */
?>

<div class="row">
	<div class="span1">
		<img src="<?php echo Yii::app()->request->baseUrl.'/'.Yii::app()->params['uploadFolder'].'/'.$data->owner_info->id.'/avatar/'.$data->owner_info->user_profile->avatar; ?>" class="img-polaroid">
		<h5 class="pagination-centered"><?php echo $data->owner_info->user_profile->real_name;?></h5>
	</div>
	<div class="span8">
		<div class="well">
						<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
				<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
				<br />

				<b><?php echo CHtml::encode($data->getAttributeLabel('owner')); ?>:</b>
				<?php echo CHtml::encode($data->owner); ?>
				<br />

				<b><?php echo CHtml::encode($data->getAttributeLabel('item')); ?>:</b>
				<?php echo CHtml::encode($data->item); ?>
				<br />

				<b><?php echo CHtml::encode($data->getAttributeLabel('details')); ?>:</b>
				<?php echo $data->details; ?>
				<br />

				<b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
				<?php echo CHtml::encode($data->create_time); ?>
				<br />

				<b><?php echo CHtml::encode($data->getAttributeLabel('viewcount')); ?>:</b>
				<?php echo CHtml::encode($data->view_count); ?>
				<br />

				<h4><a href="<?php echo Yii::app()->createUrl('/teach/question/answer',array('qid'=>$data->id)); ?>">回答</a> | <?php
				echo CHtml::ajaxLink('显示回答及追问',Yii::app()->createUrl('/teach/question/getallsubelement',array('qid'=>$data->id)),array('update'=>'#answer'.$data->id,'success'=>'js:function(data){$("#answer'.$data->id.'").html(data);$("#answer'.$data->id.'").fadeIn();}')); 
			?></h4>

			<div id="answer<?php echo $data->id ?>" style="display:none;border:1px solid #f1523a;padding:10px; margin-left:100px;">
				</div>
		</div>
	</div>
	
</div>