<div class="container  topitem">
  <div class="carton col_4 topitemcarton">
    <div class="content">
      <?php 
      	echo "第" .$current_item.edi_index . "章";
  		$children =  $current_item->level_child;
      ?>
    </div>
  </div>
</div>
<?php
	foreach( $children as $child )
	{
		echo '<div class="container"><div class="carton col_4 second_level_carton"><div class="content">第'.$child->edi_index."节</div></div></div>";
	}   
?>     
