	<div stlye="position:absolute; top:20px; right:0;">
		<p style="padding:10px; color:#3b8686; display:none;" id="problem_id_<?php echo $data->id; ?>_right">本题答案正确！</p>
		<p style="padding:10px; color:red; display:none;" id="problem_id_<?php echo $data->id; ?>_wrong">本题答案错误！正确答案是<span id="correctans<?php echo $data->id;?>"></span><a href="javascript:void(0)" style="display:none" id="pexplain<?php echo $data->id;?>">点击查看解析</a></p>
		
	</div>

	<script type="text/javascript">
		$("#pexplain<?php echo $data->id;?>").unbind('click');
		$("#pexplain<?php echo $data->id;?>").bind('click',function(){show_ans_explain(<?php echo $data->id; ?>);});
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
			echo '<input type="radio" name="select_ans['.$data->id.']" value="'.chr( 65 + $i).'"></input>';
			echo ( chr( 65 + $i) . ':' ) ;
			echo $select_ans[$i];
			echo '</span>';
		}
	}
	?>
	
