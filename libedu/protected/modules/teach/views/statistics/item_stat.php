<script type="text/javascript">
function toggle( element , class_name){
	$(element).siblings( '.' + class_name ).not('.tabheader').toggle();
	if ( $(element).children().children('.iconclass.min').text() == '[' )
	{
		$(element).children().children('.iconclass.min').text(']');
	}
	else
	{
		$(element).children().children('.iconclass.min').text('[');
	}
}
$(document).ready(function(){ 
	$(".tabs").children("#tab_one").children().not(".tabheader").toggle();
	toggle( $('.qa_stat.tabheader') , 'qa_stat' );
	$('.qa_stat.qa_item_stat').addClass('sail');
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
			output_column( 0 );	
			echo '</tr>';	
		}	
	}
	//======================end body 第一行
	
	echo '</tbody>';	
	echo '</table>'; 
?>
</div>