<ul class="tabs">
	<li class="active_tab">
	我发布的测试
	</li>
	<li class="active_tab">
	学生共建测试
	</li>
	<li class="active_tab">
	热门试卷
	</li>
	<li class="active_tab">
	收藏的试卷
	</li>
</ul>
 <div class="tabs">
     <div id="tab_one" class="tab mytab" >
     <div style="margin-left:50px">
     <?php echo $task_model->name; ?>
     <p>备注: <?php echo $task_model->description; ?></p>
     </div>
	<?php 
		foreach( $problem_data->getData() as $problem )
    	{
    		echo '<div class="carton col_4 problem_des">';
    		$this->renderPartial( '_preview_problem_box' , array('data' => $problem ) );
    		echo '</div>';
    	}
	?>
	</div>
</div>