<script type="text/javascript">
function show_ans_explain( element )
{
	$.fn.modal({
		url : '<?php echo Yii::app()->params['index_path']?>?r=teach/problem/showansexplain&problem_id=' + $(element).attr('data-id'),
    	animation:  "fadeIn"
	});
}
</script>

	<div class>
	<?php 	
		$content = $data->content;  
	?>
	</div>

	<?php 
		echo '(' . $data->source . ')';
		echo $content ; 
	?>	
	<div class="horizon_line"></div>
	<?php 
	if ( isset( $data->select_ans ) )
	{
		$select_ans = explode( "\r\n" , $data->select_ans );
		$ans_cnt = count( $select_ans );
		for( $i = 0 ; $i < $ans_cnt ; $i++ )
		{
			echo '<span style="padding-left:10px;padding-right:10px">';
			echo '<input type="radio"></input>';
			echo ( chr( 65 + $i) . ':' ) ;
			echo $select_ans[$i];
			echo '</span>';
		}
	}
	?>
