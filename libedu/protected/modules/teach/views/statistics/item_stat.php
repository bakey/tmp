<script type="text/javascript">
function toggle( element , class_name){
	$(element).siblings( '.' + class_name ).not('.tabheader').toggle();
	if ( $(element).children().children('.iconclass.min').text() == 'H' )
	{
		$(element).children().children('.iconclass.min').text('I');
	}
	else
	{
		$(element).children().children('.iconclass.min').text('H');
	}
}
$(document).ready(function(){ 
	$(".qa_stat.side_bar_word.tabheader").siblings('.side_bar_word.qa_stat"').last().addClass('current');
});
</script>

<?php
	$this->renderPartial( '_side_bar' ); 
?>
<div class="tabs">
<?php
function output_column( $content )
{
	echo '<td>' . $content . '</td>';
}
	echo '<table>';
	echo '<thead>';
	echo '<tr>';
	echo '<th>章</th>';
	echo '<th>节</th>';
	echo '<th>内容</th>';
	echo '<th>问答数</th>';
	echo '</tr>';
	echo '</thead>';
	
	echo '<tbody>';
	//body 第一行	
	for( $i = 0 ; $i < count($data) ; $i ++  )
	{
		for ( $j = 0 ; $j < count($data[$i]['children']) ; $j ++ )
		{
			echo '<tr>';
			if ( $j == 0 )
			{
				output_column('第' . $data[$i]['model']->edi_index . '章' . $data[$i]['model']->content );
			}
			else
			{
				output_column('');
			}
			output_column( '第' . $data[$i]['children'][$j]->edi_index . '节');
			output_column( $data[$i]['children'][$j]->content );
			output_column( $data[$i]['question_count'][$j] );	
			echo '</tr>';	
		}	
	}
	//======================end body 第一行
	
	echo '</tbody>';	
	echo '</table>'; 
?>
</div>