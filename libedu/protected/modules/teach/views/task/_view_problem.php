<div class="view">
	<?php
	echo '题目难度: ' . $data->getDifficulty() . " | ";
	echo '使用次数:' . $data->use_count . "|";	
	?>
	选择本题<input type="checkbox" name="problem_selected[]" value="<?php echo $data->id ?>"/>
	<?php 
	echo "<br>";
	echo '入库时间:' . $data->create_time . "<br>";
	echo '来源: ' . $data->source;
	$content = $data->content;  
	?>

	<?php 
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
			echo $select_ans[$i];
			echo "<br>";
		}
	}
	?>
	<br/>
	</b>

	<b>
	<?php
		echo CHtml::label('标准答案:    '. $data->reference_ans ,false);
		echo CHtml::label('题目类型: ' . $data->getType(),false);
		
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