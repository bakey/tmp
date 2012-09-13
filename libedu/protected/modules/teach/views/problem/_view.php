<div class="view">
    <?php header("content-type: text/html;charset=utf-8"); ?>
	<?php $contents=$data->content; 
	$str=explode("\n",$contents); ?>

	<b><?php 
	echo CHtml::encode($data->id+1);
	echo CHtml::encode('.  ');
	echo CHtml::encode('('.$data->source.')  '); ?>:</b>
	<?php echo CHtml::encode($str[0]); ?>
	<br />

	<b><?php 
	for($i=1;$i<count($str);$i++)
	{
		echo CHtml::radioButton('radio');
		$var=65+$i-1;
		echo CHtml::label(chr($var),false);
		echo CHtml::label('   ',false);
		echo CHtml::encode($str[$i]);
		echo CHtml::label('      ',false);
	}
	?>
	<br/>

	<b><?php
	echo CHtml::label('答案:    ',false);
	echo CHtml::label($data->reference_ans,false);
	echo CHtml::label('       题目类型:   ',false);
	echo CHtml::label($data->getType($data->type),false);
	?>
	<br/>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('references_ans')); ?>:</b>
	<?php echo CHtml::encode($data->references_ans); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ans_explain')); ?>:</b>
	<?php echo CHtml::encode($data->ans_explain); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('use_count')); ?>:</b>
	<?php echo CHtml::encode($data->use_count); ?>
	<br />

	*/ ?>

</div>