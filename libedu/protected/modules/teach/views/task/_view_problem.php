<span style="width:31.3%">
<?php
	echo '难度: ' . $data->getDifficulty() ;
?>
	<?php 
		echo '知识点:' ;
		echo '<font style="color: #0064CC">' ; 
		echo $data->getKnowledgePoint();
		echo '</font>';
	?>
</span>
	<?php 
	echo '入库时间:' . $data->create_time . "<br>";
	
	echo '使用次数:';	
?>
	<button onclick="select_problem(this); return false;" style="float:right">选择本题</button>
	<div class>
	<?php 	
		$content = $data->content;  
	?>
	</div>

	<?php 
		echo '(' . $data->source . ')';
		echo $content ; 
	?>	
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

	<?php
		echo CHtml::label('标准答案:    '. $data->reference_ans ,false);
		echo CHtml::label('题目类型: ' . $data->getType(),false);
		
	?>
