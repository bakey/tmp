<?php
Yii::app()->getClientScript()->scriptMap=array(
	'jquery.js'=>false,
);
?>
<script type="text/javascript">
function show_draft()
{
	//$("#draft_post").slideDown( 500 );
	$("#draft_post").toggle();
	$("#draft_box").attr( 'onclick' , 'hide_draft()' );
	$("#draft_icon").text( 'I' );
}
function hide_draft()
{
	$("#draft_post").toggle();
	$("#draft_box").attr( 'onclick' , 'show_draft()' );
	$("#draft_icon").text( 'H' );
}
function insert_draft_to_editor(element)
{
	$( "#CoursePost_title" ).val( $(element).children(".side_bar_word").children('.post_title').text() );
	$( "#CoursePost_post" ).setCode( $(element).children(".side_bar_word").children('#draft_post_content').text() );

//	$( element ).parent().children('.side_bar_word').each( function(){ alert( $(this) ); } );
//	alert( $(element).siblings().html() );
//	$( element ).children('.side_bar_word').toggleClass("sail");
	$( "#del_button" ).attr( "data-post-id" , $(element).children(".side_bar_word").children('#draft_post_id').text() );
	$( "#del_button" ).fadeIn(300);
}
</script>
<ul class="tabs">
	<li class="active_tab side_bar_word" >
		<?php
			echo CHtml::link($item_model->content , array("index&item_id=" . $item_model->id) , array('rel'=>'external') );
		?>
	</li>
	<a href="javascript:void(0)" onclick="show_draft()" id="draft_box">
		<li class="active_tab side_bar_word" >
			草稿箱(<span id="draft_post_count"><?php echo count($draft_posts); ?></span>)
			<span class="iconclass mid" id="draft_icon">H</span>
		</li>
	</a>
	<div id="draft_post" style="display:none">
	<?php
		foreach( $draft_posts as $dpost )
		{
			echo '<a href="javascript:void(0)" onclick="insert_draft_to_editor(this)" rel="external">';
			echo '<li class="side_bar_word">';
			echo '<div id="draft_post_id" style="display:none">' . $dpost->id .'</div>';
			echo '<div class="post_title" id="draft_post_title_' . $dpost->id . '">' . $dpost->title . '</div>';
			echo '<div id="draft_post_update_time">' . $dpost->update_time . '</div>';
			echo '<div id="draft_post_content" style="display:none">' . $dpost->post . '</div>';
			echo '</li>';
			echo '</a>';
		}
	?>
</div>
</ul>
<div class="tabs">
     <div id="tab_one" class="tab mytab">
     	<div>
        	<div class="content">
       			<?php
       				$this->renderPartial( '_edit_form' , array(
								'model'				 => $model,
								'base_auto_save_url' => $base_auto_save_url,
								'base_create_url'    => $base_create_url,
								'item_id'			 => $item_model->id,
							) ); 
       			?>
      		</div>
     	</div>
     </div>
</div>




