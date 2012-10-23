<script type="text/javascript">
function fetch_task( event , item_id )
{
	$.ajax(
			{
				url: '<?php echo Yii::app()->createUrl( '/teach/task/loadtaskbyitem&item_id=') ;?>' + item_id ,
				type: 'post',
				success : function( resp ) {
					var task_list = eval( '(' + resp + ')' );
					for( var i = 0 ; i < task_list.length ; i ++ )
					{
						var task_node_div = '<div class="carton col_4" style="margin-left:150px;">';
						task_node_div += task_list[i].name ;
						task_node_div += '</div>';
						$( task_node_div ).insertAfter( $( event.target ).parent('a') );
					} 
					
					
				}
			}
	);
}
</script>
<?php
foreach( $top_items as $item )
{
	$open_tag = sprintf('<a href="javascript:void(0)" onclick="fetch_task(event , %d)">' , $item->id );
	echo $open_tag;
	echo '<div class="carton col_4 task_list">';
	echo '<div class="task_info">';
	echo $item->content;
	echo '</div>';
	echo '</div>';
	echo '</a>';
	
}
?>