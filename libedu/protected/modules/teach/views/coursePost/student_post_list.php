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
		$post_ele_id = 'student_post_title_' + $post['id'];
		$li_content = sprintf('<li class="side_bar_word" id="%s">%s</li>' , $post_ele_id , $post['title'] ) ;
		$onclick_js = sprintf('$("li.side_bar_word").each(function(index,element){ var key = "#" + element.id; $( key ).removeClass("sail");  } ) ;$("#%s").addClass("sail")' , $post_ele_id );
		echo CHtml::link($li_content , 'javascript:void(0)' , array( 'rel'    => 'external' ,
																	  'onclick' => $onclick_js , 
																	  'ajax'    => array(
																					'url'    => $link,
																					'type'   => 'post',
																					'update' => '#post_content'
																	) ) );
	}
}
?>