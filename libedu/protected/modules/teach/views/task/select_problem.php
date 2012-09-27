
    <?php echo '题型: ' ?>
	<?php echo CHtml::dropDownList(
				'problem_type',
				'',
				array(''=>'请选择题型:',0=>'单项选择',1=>'多项选择',2=>'填空题',3=>'问答题'),
				array(
					'ajax'=>array(
						'type'=>'POST',
						'url'=>array('topics'),
						'update'=>'#param_id',
					),
			)
	); ?>  
	
	
    <?php echo '难度: ' ?>
	<?php echo CHtml::dropDownList('difficulty_level','',
				Problem::$difficulty_level_map ,
				array(
					'ajax'=>array(
						'type'=>'POST',
						'url'=>array('sortproblem'),
						'update'=>'#param_id',),
					)
		);?>
   
	<br><br>
    
	<?php
	
	 echo CHtml::radioButtonList(
				'sort_type','0',
				array(0=>'按照入库时间排序',1=>'按照使用次数排序'),
				array(
						'onChange'=>CHtml::ajax(
							array('type'=>'POST',
								'url'=>array('sortproblem'),
								'update'=>'#param_id',)
					)));
			
	?>

    
	<hr width=150 style="border:1px dashed red; height:1px">
   
    <div id="param_id">
    	<?php $this->renderPartial('problem_list',array(
    					'problem_data' => $problem_data
    				)); 
    	?>
    </div>