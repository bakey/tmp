<script type="text/javascript">
function extend_sub_items(ele)
{
	id = '#sub_item_' + $(ele).attr('id');
	//alert( $( id ).html() );
	$( id ).fadeIn();
	$( ele ).children('.carton').children('.content').children('.iconclass.min').text('I');
	$( ele ).attr( 'onclick' , 'hide_sub_items(this)'); 
		
}
function hide_sub_items( ele )
{
	id = '#sub_item_' + $(ele).attr('id');
	$( id ).fadeOut();
	$( ele ).children('.carton').children('.content').children('.iconclass.min').text('H');
	$( ele ).attr( 'onclick' , 'extend_sub_items(this)');
}
</script>
<?php
function getItemPostUpdateTime( $item_id )
{
	$posts = CoursePost::model()->findAll( 'item_id=:iid and author=:uid order by update_time DESC' , 
										   array(':iid' => $item_id , ':uid' => Yii::app()->user->id));
	if ( count($posts) > 0 ) {
		return $posts[0]->update_time;
	}	
	return 0;
} 
?>
<div style="margin-top:50px">
      		
       			<?php 
       				$top_item_cnt = count( $top_items );
      				//foreach( $top_items as $item )
      				for ( $i = 0 ; $i < $top_item_cnt ; ++ $i )
      				{
      					$item = $top_items[ $i ];
      					echo '<div>';
      					echo '<span class="iconclass mid" style="float:left">M</span>';
      					$anchor_node = sprintf('<a href="javascript:void(0)" id="%d" onclick="extend_sub_items(this)">',$item->id);
      					//echo '<a href="javascript:void(0)" onclick="extend_sub_item(this)">';
      					echo $anchor_node;
      					echo '<span class="carton col_4 topitemcarton">';
      					echo '<div class="content">';      					
      					echo "第" . $item->edi_index . "章" . $item->content;   
      					echo '<span class="iconclass min" style="float:right">H</span>';
      					echo '</div>';
      					echo '</span>';				
      					echo '</a>';
      					
      					$children = $item->level_child;
      					$contain_node = sprintf('<div style="display:none" id="sub_item_%d">',$item->id);
      					echo $contain_node;
      					foreach( $children as $child )
      					{
      						echo '<div class="container wrap_item ">';
      						echo '<div style="padding-left:65px;">';
      						/*if ( $i >= 0 ){
      							echo '<div style="padding-left:65px">';
      						}
      						else {
      							echo '<div style="padding-left:65px;display:none">';
      						}*/
							echo '<span class="iconclass mid" style="float:left">M</span>';
							echo '<span class="carton col_4 second_level_carton">';
							
							$post_cnt = CoursePost::model()->count( 'item_id=' . $child->id );
							$index_link_node  = sprintf('<a rel="external"  href="index.php?r=teach/coursepost/index&item_id=%d">' , $child->id );
							$create_link_node = sprintf('<a rel="external" href="index.php?r=teach/coursepost/create&item_id=%d&course_id=%d">' , $child->id , $course_id);
							if ( $post_cnt == 0 ) {	
								echo $create_link_node;			
								echo '<span class="iconclass mid item">+</span>';
							}
							else {
								echo $index_link_node;
								echo '<span class="iconclass mid item">|</span>';;
							}
							
							echo '<div style="padding-top:5px;margin-top:10px;line-height:5px">';
							echo '第'.$child->edi_index . "节 " . $child->content . "";
							$update_time = getItemPostUpdateTime( $child->id );
							echo '<p>更新时间: ' . $update_time . "</p>";
							echo '</div>';
							echo '</a></span></div></div>';
      					}
      					echo '</div>';
      					echo '</div>';
      				}
      			?>
</div>