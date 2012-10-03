<?php
/* @var $this CoursePostController */
/* @var $model CoursePost */

$this->breadcrumbs=array(
	'课程首页'=>array('index'),
	'课程资料'=>array('/teach/course/update&course_id='.$course_model->id),
	'新建课程资料',
);

?>
<h2>课程： <?php echo($course_model->name); ?></h2>
<h2>章节 : <?php echo($item_model->content) ; ?> </h2>
<h2>关联的知识点： <?php
		foreach( $relate_kp_models as $kp )
		{
			echo $kp->name . ",";
		}
		echo "<br>"; 
?></h2>

<?php
	 echo $this->renderPartial('_edit_form', array(
					'model'     		 => $model,
					'item_id'  			 => $item_model->id,
					'course_id' 		 => $course_model->id,
					'base_auto_save_url' => $base_auto_save_url,
					'base_create_url'    => $base_create_url,
			)); 
?>


