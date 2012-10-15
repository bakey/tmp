<script type="text/javascript">
function show_total_item()
{
	$("#show_item_list").html( $("#total_item_list").html() );
	$('#show_item_list a').bind("tap",function(e){window.location.href = $(this).attr("data-href")});
	$('#total_course').addClass('sail');
	$('#recent_course').removeClass('sail');
}
function show_current_item()
{
	$('#show_item_list').html( $("#current_item_list").html() ) ;
	$('#show_item_list a').bind("tap",function(e){window.location.href = $(this).attr("data-href")});
	$('#recent_course').addClass('sail');
	$('#total_course').removeClass('sail');
}

$(document).ready(function(){
	show_current_item();
});
</script>
<ul class="tabs">
<li class="active_tab">
课程首页
</li>

</ul>
 <div class="tabs">
     <div id="tab_one" class="tab mytab" >
     	
		<?php
			$current_content = '<div class="carton col_3"><div class="subcontent bordered" id="recent_course">最近课程</div></div>';
			echo CHtml::link( $current_content , '#' , array( 'onclick' => 'show_current_item()') );
			
			$content = '<div class="carton col_3"><div class="subcontent bordered" id="total_course">全部课程</div></div>';
			echo CHtml::link( $content , '#' , array( 'onclick' => 'show_total_item();') );	 
		?>					
	<div id="show_item_list"></div>
	<div id="current_item_list" style="display:none" >
	<?php
		$this->renderPartial( '_current_item_list' , array( 
									'current_item' => $current_item , 
									'item_info'	   => $item_info,
									'course_id'    => $course_id,
					) ); 
	?>
	</div>
	<div id="total_item_list"  style="display:none">
	<?php 
		$this->renderPartial( '_total_item_list' , array( 'top_items' => $top_items ) );
	?>
	</div>
	</div>
</div>   