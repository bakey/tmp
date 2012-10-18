<?php
Yii::app()->getClientScript()->scriptMap=array(
	'jquery.js'=>false,
);
?>
<script type="text/javascript">
function show_draft()
{
	$( $("#draft_post").html() ).insertAfter( '#draft_box' ) ;
	var pre = $("#draft_box").prev();
	var node = '<a href="javascript:void(0)" onclick="hide_draft()" id="draft_box">';
	$("#draft_box").remove();
	$( node ).insertAfter( pre );
}
function hide_draft()
{
	$("#draft_post").toggle();
}
function insert_draft_to_editor(element)
{
	$( "#CoursePost_title" ).val( $(element).children(".active_tab").children('#draft_post_title').text() );
	$( "#CoursePost_post" ).setCode( $(element).children(".active_tab").children('#draft_post_content').text() );
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
	草稿箱(<?php echo count($draft_posts); ?>)
	<span class="iconclass mid">H</span>
	</li>
</a>
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
<div id="draft_post" style="display:none">
<?php
foreach( $draft_posts as $dpost )
{
	echo '<a href="javascript:void(0)" onclick="insert_draft_to_editor(this)" rel="external">';
	echo '<li class="active_tab side_bar_word">';
	echo '<div id="draft_post_title">' . $dpost->title . '</div>';
	echo '<div id="draft_post_update_time">' . $dpost->update_time . '</div>';
	echo '<div id="draft_post_content" style="display:none">' . $dpost->post . '</div>';
	echo '</li>';
	echo '</a>';
}
?>
</div>



