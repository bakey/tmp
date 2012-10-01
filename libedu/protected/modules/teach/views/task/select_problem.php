<?php

	$html_options = array( 'ajax' => array(
							'type' => 'POST',
							'url'  => array('filterproblem'),
							'update' => '#param_id',
							),
						  );  
	        echo '题型: ';
			echo CHtml::dropDownList('problem_type','',	Problem::getTypeOptions(),$html_options );	
	 		echo '<br>难度: ' ;
			echo CHtml::dropDownList('difficulty_level','',Problem::$difficulty_level_map , $html_options);
         	echo '<br>科目: ';
         	echo CHtml::dropDownList( 'subject', '', Subject::getIDSubjectMap() , $html_options );
?>  
	<br><br>   
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
    <div id="param_id" class="well">
    	<?php 
    		$this->widget('bootstrap.widgets.TbListView', array(
    				'dataProvider'=>$problem_data,
    				'itemView'=>'_view_problem',
    		));
    	?>
    </div>