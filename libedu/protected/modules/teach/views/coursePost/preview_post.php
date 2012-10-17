<?php
Yii::app()->getClientScript()->scriptMap=array(
'jquery.js'=>false,
); 
?>

<script type="text/javascript">
</script>
<ul class="tabs">
	<h3>
		<div style="text-align:center">
			<?php /*echo "第" . $item_model->edi_index . "节: " . $item_model->content; */ ?>
		</div>
	</h3>
	<li class="sail">
		<?php echo $post_model->title; ?>
	</li>

</ul>
<div class="tabs" id="post_content" allowFullScreen="allowFullScreen">
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
	<?php
	    $cancel_url = sprintf( '/teach/coursepost/reedit&post_id=%s&course_id=%s' , $post_model->id , $course_id );
		$publish_url = CController::createUrl('/teach/coursepost/drafttopublished&post_id=') . $post_model->id . '&item_id=' . $item_id ;
		$cancel_url = CController::createUrl( $cancel_url );
		echo CHtml::htmlButton('发布' , array('name'=>'publish' , 'onclick' => 'window.location.href="' . $publish_url . '"' ) );
		echo CHtml::htmlButton('取消' , array('name'=>'publish' , 'onclick' => 'window.location.href="' . $cancel_url . '"' ) );
	?>
</div>
</div>
