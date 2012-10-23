<script type="text/javascript">
function show_ans_explain( element )
{
	$.fn.modal({
		url : '<?php echo Yii::app()->params['index_path']?>?r=teach/problem/showansexplain&problem_id=' + $(element).attr('data-id'),
    	animation:  "fadeIn"
	});
}
</script>
<div style="margin-top:10px; margin-left:50px;">
	<span>
	<?php
		echo '难度: ' . $data->getDifficulty() ;
	?>
	</span>
	<span style="margin-left:150px">
		<?php 
			echo '知识点:' ;
			echo '<font style="color: #0064CC">' ; 
			echo $data->getKnowledgePoint();
			echo '</font>';
		?>
	</span>
	<span style="margin-left:100px">
	正确答案:  <?php echo $data->reference_ans; ?>
	</span>
</div>

<div class="horizon_line"></div>
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
	<div class="horizon_line"></div>
	<button data-id="<?php echo $data->id; ?>" onclick="show_ans_explain(this); return false;">解析</button>
