<?php
/* @var $this CourseController */

$this->breadcrumbs=array(
	'课程管理'=>array('/teach/course/admin'),
	'Update',
);
/*
foreach( $item_post as $ip )
{
	$content = "第" . $ip['item']->edi_index . " 章<br>";
	
	if ( !$ip['post_exist'] ) 
	{
		$url = CController::createUrl('coursepost/create&item_id=' . $ip['item']->id );
		echo CHtml::link( $content , $url );
	}
	else {
		$url = CController::createUrl('coursepost/index');
		echo CHtml::link( $content , $url );
	}
}
*/
?>
	
<?php 
$url = 'course/ajaxLoadItem&edition_id=' . $edition_id.'&course_id=' . $course_id;
$this->widget(
	    'CTreeView',
		array(
            'animated'=>'fast', //quick animation
            'collapsed' => false,
            'url' => array( $url ), 
		)
);
?>
