<h2>
<div class="col_2">
	<p>
	<?php
		echo '难度: ' . $data->getDifficulty() ;
	?>
	</p>
</div>
<div class="col_3">
	<p>
		<?php 
			echo '知识点: ' ;
			echo '<font style="color: #0064CC">' ; 
			echo $data->getKnowledgePoint();
			echo '</font>';
		?>
	</p>
</div>
<div class="col_4">
	<p>
		<?php 
		echo '入库时间: ' . $data->create_time ;
		?>
	</p>
</div>
<div class="col_3">
	<p>
		<?php 	
		echo '使用次数: ' .	$data->use_count . "<br>";
		?>
	</p>
</div>
</h2>

<div class="horizon_line"></div>
<div class="col_12 normalbottommargin">

	
	<div class="col_10 problemarea">
	<?php 	
		$content = $data->content;  
	?>
	

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
	</div>
	<div class="col_2 btnarea">
		<a  href="javascript:void(0);" data-id="<?php echo $data->id; ?>" onclick="select_problem(this,<?php echo $data->id; ?>); return false;" ><img class="problemcontrol<?php echo $data->id; ?>" src="<?php echo Yii::app()->baseUrl.'/images/plus.png';  ?>"  width="48px" height="48px" /></a>
		<button data-id="<?php echo $data->id; ?>" onclick="show_ans_explain(this); return false;">解析</button>
	</div>
</div>
