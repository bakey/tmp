<?php
	$my_post = $self_post_data->getData();

	if ( count( $my_post) == 0 )
	{
		echo "<li style='text-align:center'>本章节下暂无资料</li>";
	}
	else
	{
		$tot_post_cnt = count( $my_post );
		$insert_js = 'function hide_post_title(){ var tot_post = ' . $tot_post_cnt . '; for ( i = 5; i < tot_post; i ++){ var sel_id = "#yt"+i ;  $(sel_id).children().hide(); }';
		$insert_js .= 'var prev_ele = $("#post_toggle").prev();  $("#post_toggle").remove(); ';
		$insert_js .= 'var toggle_node = "<a id=\'post_toggle\' data-href=\"javascript:void(0)\" onclick=\"insert_post_title()\" rel=\"external\"><li class=\"side_bar_word\">';
		$insert_js .= '更多<span class=\"iconclass min\">H</span></li></a>";';
		$insert_js .= '$( toggle_node ).insertAfter(prev_ele);';
		$insert_js .= '}';

		$insert_js .= ' function insert_post_title(){ var total_post = ' . $tot_post_cnt . '; for(i=5 ;i < total_post; i ++) {
				var sel_id = "#yt"+i ;  $(sel_id).children().show();  }';
		$insert_js .= 'var prev_ele = $("#post_toggle").prev();  $("#post_toggle").remove(); ';
		$insert_js .= 'var toggle_node = "<a id=\'post_toggle\' data-href=\"javascript:void(0)\" onclick=\"hide_post_title()\" rel=\"external\"><li class=\"side_bar_word\">';
		$insert_js .= '收起<span class=\"iconclass min\">I</span></li></a>";';
		$insert_js .= '$( toggle_node ).insertAfter(prev_ele);';
		$insert_js .= '}';		
		echo CHtml::script( $insert_js );
		
		$max_show_num = Yii::app()->params['max_column_show_post_num'];
		$show_cnt = 0;
		foreach( $my_post as $post )
		{
			$url         = sprintf( "index.php?r=teach/coursepost/viewbyid&post_id=%d&course_id=%d&item_id=%d" ,$post['id'],$course_id , $item_model->id );
			$post_ele_id = 'post_title_' . $post['id'];
			if ( $show_cnt >= $max_show_num )
			{	
				$li_content = '<li class="side_bar_word" id="' . $post_ele_id . '" style="display:none">' . $post['title'] . '</li>';
			}
			else if ( $show_cnt == 0 )
			{
				$li_content = '<li class="side_bar_word sail" id="' . $post_ele_id . '">' . $post['title'] . '</li>';
			}
			else
			{
				$li_content = '<li class="side_bar_word" id="' . $post_ele_id . '">' . $post['title'] . '</li>';
			}
			$onclick_js = sprintf('$("li.side_bar_word").each(function(index,element){ var key = "#" + element.id; $( key ).removeClass("sail");  } ) ;$("#%s").addClass("sail")' , $post_ele_id );
			
			echo CHtml::link( $li_content , 'javascript:void(0)' , array('rel'=>'external' , 'onclick' => $onclick_js ,
					'ajax' => array(
							'url'    => $url,
							'type'   => 'post',
							'update' => '#post_content'
					),
			));
			++ $show_cnt ;
		}

		if ( $tot_post_cnt > $max_show_num )
		{
			$url = sprintf("index.php?r=teach/coursepost/loadpostbyauthor&author=%d&item=%d" , Yii::app()->user->id , $item_model->id );
			$li_content = '<li class="side_bar_word">更多<span class="iconclass min">H</span></li>';
			echo CHtml::link( $li_content , 'javascript:void(0)' , array('rel' => 'external' ,  'onclick' => 'insert_post_title();' , 'id'=>'post_toggle') );
		}
	}

	$create_url = sprintf("index.php?r=teach/coursepost/create&item_id=%d&course_id=%d", $item_model->id, $course_id );
	$li_content = '<li class="side_bar_word">' . '创建新内容' . '<span class="iconclass min">+</span></li>';

	echo CHtml::link( $li_content , $create_url , array('rel'=>'external') );
?>