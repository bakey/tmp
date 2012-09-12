<?php
/* @var $this CourseController */

$this->breadcrumbs=array(
	'课程'=>array('/teach/course'),
	'Update',
);
foreach( $edition->getItems() as $item )
{
	echo("第" . $item->edi_index . " 章<br>");
	
}
?>