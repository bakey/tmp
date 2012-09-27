<?php
	$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$problem_data,
		'itemView'=>'_view_problem',
	));
?>