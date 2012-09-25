<?php
/* @var $this CourseController */

$this->breadcrumbs=array(
	'课程管理'=>array('/teach/course/admin'),
	'Update',
);
?>
<link rel="stylesheet" type="text/css" href="/dev/libedu/css/my.css" />
<?php
echo"<div id=\"stitle\"><h3>第" . $top_item->edi_index . "章:" . $top_item->content . "<h3></div><br>";
$children = $top_item->level_child;
foreach( $children as $child )
{
	echo"第".$child->edi_index."节 : ".$child->content . "<br>";
} 
/*$this->widget(
	    'CTreeView',
		array(
            'animated'=>'fast', //quick animation
            'collapsed' => false,
            'url' => array( $ajax_load_url ), 
		)
);
*/
?>
<div id="stitle"><h3>全部课程<h3></div>
<?php
foreach( $level_one_items as $single_item )
{
	echo "<h3>第" . $single_item->edi_index . "章   " . $single_item->content . "</h3>";	
} 
?>
