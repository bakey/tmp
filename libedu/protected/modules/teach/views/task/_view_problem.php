<script type="text/javascript">
function show_ans_explain( element )
{
	$.fn.modal({
		url : '<?php echo Yii::app()->params['index_path']?>?r=teach/problem/showansexplain&problem_id=' + $(element).attr('data-id'),
    	animation:  "fadeIn"
	});
}
</script>
<div class="col_4 offset_3">
	<p>
	<?php
		echo '难度: ' . $data->getDifficulty() ;
	?>
	</p>
	<p>
		<?php 
			echo '知识点:' ;
			echo '<font style="color: #0064CC">' ; 
			echo $data->getKnowledgePoint();
			echo '</font>';
		?>
	</p>
</div>
<div class="col_4">
	<p>
		<?php 
		echo '入库时间:' . $data->create_time ;
		?>
	</p>
	<p style="margin-left:52px">
		<?php 	
		echo '使用次数:' .	$data->use_count . "<br>";
		?>
	</p>
</div>
<div class="horizon_line"></div>
	<button data-id="<?php echo $data->id; ?>" onclick="select_problem(this); return false;" style="float:right">选择本题</button>
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
