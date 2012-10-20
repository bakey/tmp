<script type="text/javascript">
function select_problem( element )
{
	$.notification( 
			{
				title: "添加成功",
				//content: "请检查您的用户名和密码，尝试再次登陆",
				icon: "!"
			}
	);
	var current_selected = $('#choice_problem_cnt').text();
	++ current_selected;
	$('#choice_problem_cnt').text( current_selected );
}
</script>
<div class="problem_filter">
<?php

	$html_options = array( 'ajax' => array(
										'type'   => 'POST',
										'url'  	 => array('filterproblem'),
										'update' => '#param_id',
									),
							'class' => 'select_problem',
						  );  
	        echo '题型: ';
			echo CHtml::dropDownList('problem_type','',	Problem::getTypeOptions(),$html_options );	
	 		echo '难度: ' ;
			echo CHtml::dropDownList('difficulty_level','',Problem::$difficulty_level_map , $html_options);
         	echo '<br>科目: ';
         	echo CHtml::dropDownList( 'subject', '', Subject::getIDSubjectMap() , $html_options );
?>  
		<br>
    	<span>
    		<button>选择知识点</button>
    	</span>
    	<span>
    		<button>题目筛选</button>
    	</span>
  
</div>
<div class="horizon_line"></div>  
	<?php	
	 echo CHtml::radioButtonList(
				'sort_type','0',
				array(0=>'按照入库时间排序',1=>'按照使用次数排序'),
				array(
						'onChange'=>CHtml::ajax(
							array('type'=>'POST',
								'url'=>array('filterproblem'),
								'update'=>'#param_id',)
					)));
			
	?>       
    <div id="param_id" >
    	<?php 
    		foreach( $problem_data->getData() as $problem )
    		{
    			echo '<div class="carton col_4 problem_des">';
    			$this->renderPartial( '_view_problem' , array('data' => $problem ) );
    			echo '</div>';
    		}
    	?>
    </div>