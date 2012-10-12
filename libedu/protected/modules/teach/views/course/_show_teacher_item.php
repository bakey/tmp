<ul class="tabs">
<li class="active_tab">
课程首页
</li>

</ul>
 <div class="tabs">
     <div id="tab_one" class="tab mytab">
     <div>
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
		$anchor = sprintf('<a rel="external" href="index.php?r=teach/coursepost/index&item_id=%d">' , $child_item_info['id'] );
		//echo $anchor;
		echo '<div class="container wrap_item">';
		echo '<div style="padding-left:65px">';
		echo '<span class="iconclass mid" style="float:left">M</span>';
		echo '<div class="carton col_4 second_level_carton">';
		echo '<div class="content item_name">';
		if ( $child_item_info['post_count'] > 0 ) 
		{
			echo '<span class="iconclass mid item">|</span>';
		}
		else
		{
			echo '<span class="iconclass mid item">+</span>';
		}
		echo '<div style="padding-top:5px;margin-top:10px">';
		echo $anchor . '第'.$child_item_info['item_index'] . "节 " . $child_item_info['content'] . "";
		echo '</div>';
		echo '</a><div style="clear:both">&nbsp;</div></div></div></div></div>';
	}   
?> 
     </div>
</div>

   