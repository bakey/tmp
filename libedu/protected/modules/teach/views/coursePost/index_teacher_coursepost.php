<?php
Yii::app()->getClientScript()->scriptMap=array(
'jquery.js'=>false,
); 
?>

<script type="text/javascript">

</script>
<ul class="tabs">
<h3>
	<div style="text-align:center">
		<?php echo "第" . $item_model->edi_index . "节: " . $item_model->content; ?>
	</div>
</h3>
<div class="side_bar_word">课程资料</div>
<?php
	$first_post_id = -1 ;
	$my_post = $self_post_data->getData();
	
	if ( count( $my_post) == 0 )
	{
		echo "<li class>本章节下暂无资料</li>";
	}	
	else
	{
		$max_show_num = Yii::app()->params['max_column_show_post_num'];
		$show_cnt = 0;
		foreach( $my_post as $post )
		{
			if ( $first_post_id < 0 ) {
				$first_post_id = $post->id;
			}
			$url         = sprintf( "index.php?r=teach/coursepost/viewbyid&post_id=%d&course_id=%d&item_id=%d" ,$post['id'],$course_id , $item_model->id );
			/*$anchor_node = sprintf('<a rel="external" href="index.php?r=teach/coursepost/viewbyid&post_id=%d&course_id=%d&item_id=%d">'
					 ,$post['id'],$course_id , $item_model->id);*/
			$post_ele_id = 'post_title_' . $post['id'];
			$li_content = '<li class="side_bar_word" id="' . $post_ele_id . '">' . $post['title'] . '</li>';
			$onclick_js = sprintf('$("#%s").addClass("sail")' , $post_ele_id );
			echo CHtml::link( $li_content , '#' , array('rel'=>'external' , 'onclick' => $onclick_js , 'ajax' => array(
																										'url'    => $url,
																										'type'   => 'post',
																										'update' => '#post_content'
																										)));		
			++ $show_cnt ; 
			if ( $show_cnt >= $max_show_num ) {
				break;
			}
		} 
		if ( count($my_post) > $max_show_num )
		{
			$li_content = '<li class="side_bar_word">更多<span class="iconclass min">H</span></li>';
			echo CHtml::link( $li_content , '#' , array('rel' => 'external' , 'onclick' => '') );
		}
	}
	$post_model = null;
	if ( $first_post_id > 0 ) {
		$post_model = CoursePost::model()->findByPk( $first_post_id );
	}
	$create_url = sprintf("index.php?r=teach/coursepost/create&item_id=%d&course_id=%d",$item_model->id,
					$course_id );
	$li_content = '<li class="side_bar_word">' . '创建新内容' . '</li>';
	echo CHtml::link( $li_content , $create_url , array('rel'=>'external') );
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

<div class="tabs" id="post_content" allowFullScreen="allowFullScreen">
<?php  
$this->renderPartial( 'teacher_view_post' , array('post_model' => $post_model) );
?>
</div>
