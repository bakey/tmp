<script type="text/javascript">
function fetch_task( element , item_id )
{
	var items = $( element ).next('div.carton.col_4.item_task_list');
	if ( items.length > 0 )
	{
		items.fadeOut(300);
		items.remove();
		return ;		
	}
	$.ajax(
			{
				url: '<?php echo Yii::app()->createUrl( '/teach/task/loadtaskbyitemasstudent&item_id=') ;?>' + item_id + '&user_id=<?php echo Yii::app()->user->id ;?>',
				type: 'post',
				success : function( resp ) {
					var task_list = eval( '(' + resp + ')' );			
					var insert_cnt = 0;
					for( var i in task_list )
					{
						var task_node_div = '<div class="carton col_4 item_task_list">';
						task_node_div += '<span class="check_task_btn">';
						if ( task_list[i].status == 1 )
						{
							task_node_div += '<button onclick="window.location.href=\'<?php echo Yii::app()->createUrl("/teach/task/previewtask&task_id=");?>' + task_list[i].id + '\'">查看练习</button>';
						}
						else
						{
							task_node_div += '<button onclick="window.location.href=\'<?php echo Yii::app()->createUrl("/teach/task/previewtask&task_id=");?>' + task_list[i].id + '\'">进入练习</button>';
						}
						task_node_div += '</span>';
						task_node_div += '<div style="margin-top:10px">';
						task_node_div += task_list[i].name + '<br>';
						task_node_div += '</div>';
						task_node_div += task_list[i].create_time ;
						task_node_div += '</div>';
						$( task_node_div ).insertAfter( $( element ) );
						++ insert_cnt;
					} 
					if ( insert_cnt <= 0 )
					{
						if ( task_list.length <= 0 )
						{
							$.notification ( 
								  {
								        title:      '此章节下暂无练习',
								        content:    ''
								  }
							);
							return ;
						}
					}
					
					
				}
			}
	);
}
</script>
<?php
foreach( $top_items as $item )
{
	$open_tag = sprintf('<a href="javascript:void(0)" onclick="fetch_task(this , %d)">' , $item->id );
	echo $open_tag;
	echo '<div class="carton col_4 task_list">';
	echo '<div class="task_info">';
	echo $item->content;
	echo '</div>';
	echo '</div>';
	echo '</a>';
	
}
?>