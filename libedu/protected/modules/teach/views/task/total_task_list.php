<?php
foreach( $top_items as $item )
{
	echo '<div class="carton col_4 task_list">';
	echo $item->content;
	echo '</div>';
}
?>