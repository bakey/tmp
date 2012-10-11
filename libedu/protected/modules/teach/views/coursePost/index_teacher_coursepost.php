

<h3>
<?php echo "第" . $item_model->edi_index . "节: " . $item_model->content; ?>
</h3>
<p>课程资料</p>
<ul class="tabs">

<?php
	$my_post = $self_post_data->getData();
	$first_post_id = -1 ;
	foreach( $my_post as $post )
	{
		$first_post_id = $post->id;
		$link = sprintf('<a rel="external" href="index.php?r=teach/coursepost/viewbyid&post_id=%d&course_id=%d&item_id=%d">'
					 ,$post['id'],$course_id , $item_model->id);
		$li_content = '<li class>' . $post['title'] . '</li>';
		echo $link;
		echo $li_content;
		echo "</a>";
//		$anchor = sprintf('<a rel="external" href="index.php?r=teach/coursepost/viewbyid&post_id=%d$course_id=%d&item_id=%d">' );
		
	/*	echo CHtml::link($li_content , '#' , array('rel'=>'external' , 'ajax' => array(
				'url'    => $link,
				'type'   => 'post',
				'update' => '#post_content'
		) ) );*/		
	} 
?>
其他老师的课程资料
<li class>
<?php
	$other_post = $other_teacher_data->getData();
	if ( count( $other_post) == 0 )
	{
		echo "<li class>其他老师暂未在该课程下发表资料</li>";
	}
	else
	{
		foreach( $other_post as $post )
		{
			$link = sprintf("index.php?r=teach/coursepost/viewbyid&post_id=%d&course_id=%d&item_id=%d" ,$post['id'],$course_id , $item_model->id);
			$li_content = '<li class>' . $post['title'] . '</li>';
			echo CHtml::link($li_content , '#' , array('rel'=>'external' , 'ajax' => array(
				'url'    => $link,
				'type'   => 'post',
				'update' => '#post_content'
			) ) );	
		} 
	}
?>
</li>
学生贡献的课程资料
<li class>
<?php
	$student_post = $student_post_data->getData();
	if ( count( $student_post) == 0 )
	{
		echo "<li class>学生暂未在该课程下发表资料</li>";
	}
	else
	{
		foreach( $student_post as $post )
		{
			$link = sprintf("index.php?r=teach/coursepost/viewbyid&post_id=%d&course_id=%d&item_id=%d" ,$post['id'],$course_id , $item_model->id);
			$li_content = '<li class>' . $post['title'] . '</li>';
			echo CHtml::link($li_content , '#' , array('rel'=>'external' , 'ajax' => array(
				'url'    => $link,
				'type'   => 'post',
				'update' => '#post_content'
			) ) );	
		} 
	}
?>
</li>
</ul>

<div class="tabs" id="post_content">
<?php
  if ( $first_post_id > 0 )
  {
  	$post_model = CoursePost::model()->findByPk( $first_post_id );
  	$this->renderPartial( 'teacher_view_post' , array('model' => $post_model) );
  } 
?>
</div>
