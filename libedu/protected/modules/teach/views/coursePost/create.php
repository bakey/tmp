<?php
/* @var $this CoursePostController */
/* @var $model CoursePost */

$this->breadcrumbs=array(
	'Course Posts'=>array('index'),
	'Create',
);

?>

<h1>新建课程资料</h1>

<?php
	 echo $this->renderPartial('_edit_form', array(
					'model'   => $model,
					'item_id' => $item_id,
			)); 
?>


