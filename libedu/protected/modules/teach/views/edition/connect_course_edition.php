<script type="text/javascript">

function clear_active_tab()
{
	$(".subcontent.bordered").each( function(i){ $(this).removeClass('sail' );
			});
	
}
function changeToTabByIndex( element ,targettabindex) {
	clear_active_tab();
	$(element).children().children('.subcontent.bordered').addClass('sail');	
}
</script>


<div class="container dotbottom normaltoppadding">
<a href="javascript:void(0);" onclick="changeToTabByIndex( this ,0)" rel="external">
	<div class="carton col_3">
		<div class="subcontent bordered sail">
								高一
		</div>
	</div>
</a>

<a href="javascript:void(0);" onclick="changeToTabByIndex( this ,1)" rel="external">
	<div class="carton col_3">
		<div class="subcontent bordered">
								高二
		</div>
	</div>
</a>


<a href="javascript:void(0);" onclick="changeToTabByIndex( this ,1)" rel="external">
	<div class="carton col_3">
		<div class="subcontent bordered">
								高三
		</div>
	</div>
</a>
</div>
<div id="grade_10">
	<?php
		$this->renderPartial('_form_show_edition' , array( 'dataProvider' => $dataProvider , 'course_edi' => $course_edi[10] ) ); 
	?>
</div>