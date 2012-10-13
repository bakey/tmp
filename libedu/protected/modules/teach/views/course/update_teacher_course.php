<?php
Yii::app()->getClientScript()->scriptMap=array(
'jquery.js'=>false,
); 
?>
<?php
$this->renderPartial( '_show_teacher_item' , array( 
									'current_item' => $current_item , 
									'item_info'	   => $item_info,
									'course_id'    => $course_id,
									'top_items'    => $level_one_items,
					) );
?>

