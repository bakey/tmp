
<h1>班级管理</h1>


<?php 
$this->widget('zii.widgets.CListView', array(
	'id'=>'lib-class-grid',
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view_class',
));
 ?>

