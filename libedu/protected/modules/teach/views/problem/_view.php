<div class="view">
	<?php
		$content = $data->content;  
	?>

	<b>
	<?php 
	echo CHtml::encode($data->id+1);
	echo CHtml::encode('.  ');
	echo CHtml::encode('('.$data->source.')  '); ?>:
	</b>
	<?php 
		//echo CHtml::encode($str[0]);
		echo $content ; 
	?>
	
	<br />

	<b>
	<?php 
	if ( isset( $data->select_ans ) )
	{
		$select_ans = explode( "\r\n" , $data->select_ans );
		$ans_cnt = count( $select_ans );
		for( $i = 0 ; $i < $ans_cnt ; $i++ )
		{
			echo ( chr( 65 + $i) . ':' ) ;
			echo CHtml::label('   ',false);
			echo $select_ans[$i];
			echo "<br>";
			echo CHtml::label('      ',false);
		}
	}
	?>
	<br/>
	</b>

	<b><?php
	echo CHtml::label('标准答案:    ',false);
	echo CHtml::label($data->reference_ans,false);
	echo CHtml::label('&nbsp;&nbsp;<br>题目类型:&nbsp;&nbsp;',false);
	echo CHtml::label($data->getType($data->type),false);
	?>
	<br/>
	</b>


	<pre>
	<?php
	$knowledgePoints = $data->problem_kp;
	if ( count($knowledgePoints ) > 0 ) {
		echo("<font color=\"#FF0000\"><p>关联的知识点:</p></font>");
		foreach( $knowledgePoints as $key=>$kp )
		{
			echo( $key . ": " . $kp->name . "|<br>");
		}
	}
	
	 ?>
	 </pre>

</div>