<?php
$other_post = $other_teacher_data->getData();
if ( count( $other_post) == 0 )
{
	echo "<li class>其他老师暂未在该章节下发表资料</li>";
}
else
{
	$max_show_num = Yii::app()->params['max_column_show_post_num'];
	$show_cnt = 0;
	$tot_post_cnt = count( $other_post );
	
	foreach( $other_post as $post )
	{
		$link = sprintf("index.php?r=teach/coursepost/viewbyid&post_id=%d&course_id=%d&item_id=%d" ,$post['id'],$course_id , $item_model->id);
		
		$post_ele_id = 'other_teacher_post_title_' . $post['id'];		
		if ( $show_cnt >= $max_show_num )
		{
			$li_content = '<li class="side_bar_word" id="' . $post_ele_id . '" style="display:none">' . $post['title'] . '</li>';
		}
		else
		{
			$li_content = '<li class="side_bar_word" id="' . $post_ele_id . '">' . $post['title'] . '</li>';
		}
		$onclick_js = sprintf('$("li.side_bar_word").each(function(index,element){ var key = "#" + element.id; $( key ).removeClass("sail");  } ) ;$("#%s").addClass("sail")' , $post_ele_id );
		echo CHtml::link($li_content , 'javascript:void(0)' , array('rel'=>'external' , 'onclick' => $onclick_js , 'ajax' => array(
				'url'    => $link,
				'type'   => 'post',
				'update' => '#post_content'
		) ) );
		++ $show_cnt;
	}
	if ( $tot_post_cnt > $max_show_num )
	{
		//$url = sprintf("index.php?r=teach/coursepost/loadpostbyauthor&author=%d&item=%d" , Yii::app()->user->id , $item_model->id );
		//$li_content = '<li class="side_bar_word">更多<span class="iconclass min">H</span></li>';
		//echo CHtml::link( $li_content , 'javascript:void(0)' , array('rel' => 'external' ,  'onclick' => 'insert_post_title();' , 'id'=>'post_toggle') );
	}
}
?>