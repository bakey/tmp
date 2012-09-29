<div class="well">

<?php 
echo '来源: ' . $data['source'];
?>

<?php 	
if ( $data['check_ans'] ) {
	$msg = sprintf( '<div style="color:red">您的答案是: (%s) 您的答案正确</div>' , $data['user_ans'] );
	echo $msg ;
}else {
	$msg = sprintf( '<div style="color:red">您的答案是: (%s) 您的答案错误</div>' , $data['user_ans'] );
	echo $msg ;
}
	echo $data['content'];
	//展示选择题的选项
	if ( isset( $data['select_ans'] ) )
	{
		$select_ans = explode( "\r\n" , $data['select_ans'] );
		$ans_cnt = count( $select_ans );
		
		$selection = array();		
		for( $i = 0 ; $i < $ans_cnt ; $i++ )
		{
			$selection[ $i ] = $select_ans[$i];
			
			$button_name = @sprintf( "select_ans[%d]" , $data['id'] );
			echo $select_ans[$i];
			echo "<br>";
		}
	}
	//echo CHtml::label('题目类型: ' . $data->getType($data->type),false);
?>
</div>