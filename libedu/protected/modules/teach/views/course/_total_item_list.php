<div style="margin-top:50px">
      		
       			<?php 
       				$top_item_cnt = count( $top_items );
      				//foreach( $top_items as $item )
      				for ( $i = 0 ; $i < $top_item_cnt ; ++ $i )
      				{
      					$item = $top_items[ $i ];
      					echo '<span class="iconclass mid" style="float:left">M</span>';
      					echo '<a href="javascript:void(0)" onclick="">';
      					echo '<div class="carton col_4 topitemcarton">';
      					echo '<div class="content">';      					
      					echo "第" . $item->edi_index . "章" . $item->content;   
      					echo '<span class="iconclass min" style="float:right">H</span>';
      					echo '</div>';
      					echo '</div>';				
      					echo '</a>';
      					
      					$children = $item->level_child;
      					foreach( $children as $child )
      					{
      						echo '<div class="container wrap_item " style="">';
      						/*if ( $i >= 0 ){
      							echo '<div style="padding-left:65px">';
      						}
      						else {
      							echo '<div style="padding-left:65px;display:none">';
      						}*/
      						
      						echo '<div style="padding-left:65px">';
							echo '<span class="iconclass mid" style="float:left">M</span>';
							echo '<div class="carton col_4 second_level_carton">';
							
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
							
							echo '<div style="padding-top:5px;margin-top:10px">';
							echo '第'.$child->edi_index . "节 " . $child->content . "";
							echo '</div>';
							echo '</a></div></div></div></div>';
      					}
      				}
      			?>
</div>