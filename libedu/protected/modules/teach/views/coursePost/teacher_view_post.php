 <script type="text/javascript">
 function show_edit_icon()
 {
 	$("#edit_icon").fadeIn();
 }
 function hide_edit_icon()
 {
	 $("#edit_icon").fadeOut();
 }
 function full_screen()
 {
	 var box = '<div class="redactor_box_fullscreen"><a></a></div>';
	 box.prepend( $('#tab_one') );
	 alert( $(box).html() );
	 $(document.body).prepend( $(box) ).css('overflow', 'hidden');
 }
 </script>
 <?php
 if ( $post_model != null )
 {
 	$reedit_url = Yii::app()->params['index_path'] . '?r=teach/coursepost/reedit&post_id=' . $post_model->id . '&course_id='. $course_id ;
 } 
 ?>
<button style="margin-left:2000x; float:right" onclick="full_screen()">full</button>
 <div id="tab_one" class="tab mytab current" >
 <?php
 	if ( $post_model != null )
 	{
 		if ( $post_model->author == Yii::app()->user->id )
 		{
 			echo CHtml::link( '<span class="iconclass mid"  style="position:absolute; top:0; z-index:999;" id="edit_icon">C</span>' , $reedit_url , 
 				array('rel' => 'external') );
 		}
 	} 
 ?>
 	<div class="carton col_4 topitemcarton post_title" >
 		<div class="content post_title" >
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

