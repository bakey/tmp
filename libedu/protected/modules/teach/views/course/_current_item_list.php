 <div style="margin-top:50px">
     <span class="iconclass mid" style="float:left">M</span>
       <div class="carton col_4 topitemcarton">
    		<div class="content">
       			<?php 
      				echo "第" .$current_item->edi_index . "章 " . $current_item->content ;
      			?>
      		</div>
        </div>
  </div>
        <?php
	foreach( $item_info as $child_item_info )
	{
		$index_link_node  = sprintf('<a rel="external"  href="index.php?r=teach/coursepost/index&item_id=%d">' , $child_item_info['id'] );
		$create_link_node = sprintf('<a rel="external" href="index.php?r=teach/coursepost/create&item_id=%d&course_id=%d">' , $child_item_info['id'] , $course_id);
		//echo $anchor;
		echo '<div class="container wrap_item">';
		echo '<div style="padding-left:65px">';
		echo '<span class="iconclass mid" style="float:left">M</span>';
		echo '<div class="carton col_4 second_level_carton">';
		echo '<div class="content item_name">';
		if ( $child_item_info['post_count'] > 0 ) 
		{
			echo $index_link_node;
			echo '<span class="iconclass mid item">|</span>';
		}
		else
		{
			echo $create_link_node;
			echo '<span class="iconclass mid item">+</span>';
		}
		echo '<div style="padding-top:5px;margin-top:10px">';
		echo '第'.$child_item_info['item_index'] . "节 " . $child_item_info['content'] . "";
		echo '<p>更新时间: ' . $child_item_info['update_time'] . "</p>";
		echo '</div>';
		echo '</a></div></div></div></div>';
	}   
?> 