 <script type="text/javascript">
 function show_edit_icon()
 {
	// alert( $("#edit_icon").html() );
 	$("#edit_icon").fadeIn();
 }
 function hide_edit_icon()
 {
	 $("#edit_icon").fadeOut();
 }
 </script>
 <?php
 if ( $post_model != null )
 {
 	$reedit_url = Yii::app()->params['index_path'] . '?r=teach/coursepost/reedit&post_id=' . $post_model->id . '&course_id='. $course_id ;
 } 
 ?>

 <div id="tab_one" class="tab mytab current" >
 <?php
 	if ( $post_model != null )
 	{
 		echo CHtml::link( '<span class="iconclass mid"  style="position:absolute; top:0; z-index:999;" id="edit_icon">C</span>' , $reedit_url , 
 				array('rel' => 'external') );
 	} 
 ?>
 	<div class="carton col_4 topitemcarton post_title" >
 		<div class="content">
    <?php
    	if ( $post_model != null ) 
		{
 			echo $post_model->title ;
		} 
 	?>
  		</div>
	</div>
	<div class="carton post_grid" >
		<?php 
			if ( $post_model != null )
			{
				echo $post_model->post;
			}
		?>
	</div>
</div>

