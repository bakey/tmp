<div style="margin-top:50px">
      		
       			<?php 
      				foreach( $top_items as $item )
      				{
      					echo '<span class="iconclass mid" style="float:left">M</span>';
      					echo '<div class="carton col_4 topitemcarton">';
      					echo '<div class="content">';      					
      					echo "第" . $item->edi_index . "章" . $item->content;      	
      					echo '</div>';
      					echo '</div>';				
      				}
      			?>
</div>