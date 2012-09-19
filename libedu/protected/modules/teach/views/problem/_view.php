<div class="view">
	<?php
	$contents = $data->content; 
	$str=explode("\n",$contents); ?>

	<b>
	<?php 
	echo CHtml::encode($data->id+1);
	echo CHtml::encode('.  ');
	echo CHtml::encode('('.$data->source.')  '); ?>:
	</b>
	<?php 
		//echo CHtml::encode($str[0]);
		echo $str[0]; 
	?>
	
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
	echo CHtml::label('&nbsp;&nbsp;|&nbsp;&nbsp;题目类型:&nbsp;&nbsp;',false);
	echo CHtml::label($data->getType($data->type),false);
	?>
	<br/>


	<pre>
	<?php
	$knowledgePoints = $data->problem_kp;
	if ( count($knowledgePoints ) > 0 ) {
		echo("<p>关联的知识点:</p>");
		foreach( $knowledgePoints as $key=>$kp )
		{
			echo( $key . ": " . $kp->name . "|<br>");
		}
	}
	
	 ?>
	 </pre>

</div>