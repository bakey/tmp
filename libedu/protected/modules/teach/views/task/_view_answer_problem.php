<div class="well">

<div id="problem_id_<?php echo $data->id?>">
<?php 
echo '来源: ' . $data->source;
?>
</div>

<?php 
	
	echo $data->content;
	//展示选择题的选项
	if ( isset( $data->select_ans ) )
	{
		$select_ans = explode( "\r\n" , $data->select_ans );
		$ans_cnt = count( $select_ans );
		
		$selection = array();		
		for( $i = 0 ; $i < $ans_cnt ; $i++ )
		{
			$selection[ $i ] = $select_ans[$i];
			
			$button_name = @sprintf( "select_ans[%d]" , $data->id );
			echo CHtml::radioButton( $button_name , false , array(
							//'id'=>'select_ans_' . $i
							'value'=>$i,
						) 
					);
			echo $select_ans[$i];
			echo "<br>";
		}
	}
	echo CHtml::label('题目类型: ' . $data->getType($data->type),false);
?>
</div>