<?php
Yii::app()->getClientScript()->scriptMap=array(
'jquery.js'=>false,
);
?>

 
<ul class="tabs">
	<a href="index.php?r=teach/task" rel="external">
		<li class="side_bar_head active_tab current">
		本校教材
		</li>
	</a>
	<li class="side_bar_head">
		上传教材
	</li>
	<li class="side_bar_head">
		教材库
	</li>
	<li class="side_bar_head">
		收藏的教材
	</li>
</ul>
<div class="tabs">
<?php
	$this->renderPartial('connect_course_edition', array( 'dataProvider'=>$dataProvider , 'course_edi' => $course_edi ) ); 
?>
</div>