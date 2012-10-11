<div class="container  topitem">
  <div class="carton col_4 topitemcarton">
    <div class="content">
      <?php 
      	echo "第" .$current_item->edi_index . "章 " . $current_item->content ;
  		$children =  $current_item->level_child;
      ?>
    </div>
  </div>
</div>

<?php
	foreach( $children as $child )
	{
		$anchor = sprintf('<a rel="external" href="index.php?r=teach/coursepost/index&item_id=%d">' , $child->id );
		echo $anchor;
		echo '<div class="container"><div class="carton col_4 second_level_carton"><div class="content">第'.$child->edi_index."节 " .$child->content 
				."<br>创建时间: " . $child->create_time . "</div></div></div>";
		echo "</a>";
	}   
?>     
