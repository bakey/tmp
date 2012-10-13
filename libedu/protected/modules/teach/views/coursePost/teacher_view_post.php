 <div id="tab_one" class="tab mytab current">
 	<div class="carton col_4 topitemcarton post_title" >
 		<div class="content">
    <?php
    	if ( $post_model != null ) 
		{
 			echo $post_model->id . ": " . $post_model->title ;
		} 
 	?>
  		</div>
	</div>
<div class="carton post_grid">
<?php 
	if ( $post_model != null )
	{
		echo $post_model->post;
	}
?>
</div>
</div>

