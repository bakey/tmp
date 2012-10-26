<?php
Yii::app()->getClientScript()->scriptMap=array(
'jquery.js'=>false,
);
?>

<h1>班级管理</h1>

<?php 
$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view_class',
));

?>