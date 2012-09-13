<?php
/* @var $this CourseController */

$this->breadcrumbs=array(
	'课程'=>array('/teach/course'),
	'Update',
);
foreach( $edition->getItems() as $item )
{
	$content = "第" . $item->edi_index . " 章<br>";
	$url = CController::createUrl('coursepost/create&item_id=' . $item->id );
	echo CHtml::link( $content , $url );
}
?>