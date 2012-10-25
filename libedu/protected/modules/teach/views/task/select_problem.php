<script type="text/javascript">
function select_problem( element, pid )
{
	$.notification( 
			{
				title: "添加成功",
				content: "Congrats...",
				icon: "!"
			}
	);
	var current_selected = $('#choice_problem_cnt').text();
	++ current_selected;
	$('#choice_problem_cnt').text( current_selected );
	var sel_problem = '<input id="probleminput'+pid+'" name="Task[]" style="display:none" value="' + $( element ).attr('data-id') + '" ></input>'; 
	$('#problem_selected').append( sel_problem );
	$('#singleproblem'+pid).fadeOut();
	var newelement = $('#singleproblem'+pid).clone();
	$(newelement).attr('id','singlechosenproblem'+pid).hide();
	$('#chosenlist').append($(newelement));
	$('#singlechosenproblem'+pid).find('.problemcontrol'+pid).attr('src','<?php echo Yii::app()->baseUrl."/images/cross.png"; ?>').parent().attr('onclick','$("#singlechosenproblem'+pid+'").fadeOut().remove();$("#singleproblem'+pid+'").fadeIn();$("#probleminput'+pid+'").remove();$("#choice_problem_cnt").text(parseInt($("#choice_problem_cnt").text())-1);');
	$('#singlechosenproblem'+pid).addClass('chosen').removeClass('col_12').addClass('col_11').fadeIn();
}

function show_ans_explain( element )
{
	$.fn.modal({
		url : '<?php echo Yii::app()->createUrl("teach/problem/showansexplain");?>'+ '&problem_id=' + $(element).attr('data-id'),
    	animation:  "fadeIn"
	});
}
</script>


<div class="problem_filter col_12 normalbottommargin">
	<div class="col_8">
		<?php

			$html_options = array( 'ajax' => array(
												'type'   => 'POST',
												'url'  	 => array('filterproblem'),
												'update' => '#param_id',
											),
									'class' => 'select_problem',
								  );  
			echo ' 题型: ';
			echo CHtml::dropDownList('problem_type','',	Problem::getTypeOptions(),$html_options );	
			echo ' 难度: ' ;
			echo CHtml::dropDownList('difficulty_level','',Problem::$difficulty_level_map , $html_options);
		?>  
	</div>
	<div class="col_4">
		<button>选择章节</button>
		<button>题目筛选</button>
	</div>

	<div class="col_12">
		<?php	
	 echo CHtml::radioButtonList(
				'sort_type','0',
				array(0=>'按照入库时间排序',1=>'按照使用次数排序'),
				array(
						'onChange'=>CHtml::ajax(
								array(	'type'=>'POST',
										'url'=>array('filterproblem'),
										'update'=>'#param_id',)
					)));
			
	?>  
	</div>
</div>
	     
    <div id="param_id" class="col_12" >
    	<?php 
    		$this->renderPartial( 'problem_list' , array( 'problem_data' => $problem_data ) );
    	?>
    </div>