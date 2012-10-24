<?php
Yii::app()->getClientScript()->scriptMap=array(
'jquery.js'=>false,
); 
?>

<ul class="tabs">
	<h3>
		<div style="text-align:center">
			<?php echo "第" . $item_model->edi_index . "节: " . $item_model->content; ?>
		</div>
	</h3>
	<li>
		<div class="side_bar_word">课程资料</div>
<?php
	$post_data = $course_teacher_post_data->getData();
	$post_model = null;
	if ( count($post_data) > 0 )
	{
		$post_model = CoursePost::model()->findByPk( $post_data[0]['id'] );
	}
	$this->renderPartial( 'my_course_post_list' , array( 'self_post_data' => $course_teacher_post_data , 'course_id' => $course_id , 'item_model' => $item_model ) );
?>
	</li>
	<li class>
	<div style="text-align:center">我贡献的课程资料</div>
	
	<?php
		$this->renderPartial( 'my_course_post_list' , array(  'self_post_data' => $my_post_data , 'course_id' => $course_id ,
							  'item_model' => $item_model) );
	?>
	</li>
	<li>
	
	<div style="text-align:center">其他老师的课程资料</div>	
	<?php
		$this->renderPartial( 'other_teacher_post_list' , array( 'other_teacher_data' => $other_teacher_post_data , 'course_id' => $course_id , 
								'item_model' => $item_model) );
	?>
	</li>

	
</ul>
<div class="tabs" id="post_content" allowFullScreen="allowFullScreen">
	<?php  
		$this->renderPartial( 'teacher_view_post' , array('post_model' => $post_model , 'course_id' => $course_id ) );
	?>
</div>
