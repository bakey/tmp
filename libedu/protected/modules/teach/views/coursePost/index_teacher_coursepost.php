<?php
Yii::app()->getClientScript()->scriptMap=array(
'jquery.js'=>false,
); 
?>

<h3>

</h3>

<ul class="tabs">
<h3><div style="text-align:center"><?php echo "第" . $item_model->edi_index . "节: " . $item_model->content; ?></div></h3>
<div style="text-align:center">课程资料</div>
<?php
	$first_post_id = -1 ;
	$my_post = $self_post_data->getData();
	if ( count( $my_post) == 0 )
	{
		echo "<li class>本章节下暂无资料</li>";
	}	
	else
	{
		foreach( $my_post as $post )
		{
			if ( $first_post_id < 0 ) {
				$first_post_id = $post->id;
			}
			$url = sprintf( "index.php?r=teach/coursepost/viewbyid&post_id=%d&course_id=%d&item_id=%d" ,
					$post['id'],$course_id , $item_model->id );
			$link = sprintf('<a rel="external" href="index.php?r=teach/coursepost/viewbyid&post_id=%d&course_id=%d&item_id=%d">'
						 ,$post['id'],$course_id , $item_model->id);
			$li_content = '<li class>' . $post['title'] . '</li>';
			echo CHtml::link($li_content , '#' , array('rel'=>'external' , 'ajax' => array(
																					'url'    => $url,
																					'type'   => 'post',
																					'update' => '#post_content'
			) ) );		
		} 
	}
	$post_model = null;
	if ( $first_post_id > 0 ) {
		$post_model = CoursePost::model()->findByPk( $first_post_id );
	}
?>
<div style="text-align:center">其他老师的课程资料</div>
<li class>
<?php
	$other_post = $other_teacher_data->getData();
	if ( count( $other_post) == 0 )
	{
		echo "<li class>其他老师暂未在该章节下发表资料</li>";
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
<div style="text-align:center">学生贡献的课程资料</div>
<li class>
<?php
	$student_post = $student_post_data->getData();
	if ( count( $student_post ) == 0 )
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
$this->renderPartial( 'teacher_view_post' , array('post_model' => $post_model) );
	if ( $post_model != null )
	{	
  		//$this->renderPartial( 'teacher_view_post' , array('post_model' => $post_model) );
	}
?>
</div>
