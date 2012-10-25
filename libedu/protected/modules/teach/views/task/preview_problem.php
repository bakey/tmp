<ul class="tabs">
	<a href="index.php?r=teach/task" rel="external">
		<li class="active_tab side_bar_word sail">
		我的练习
		</li>
	</a>
	<li class="active_tab side_bar_word">
	共建练习
	</li>
	<li class="active_tab side_bar_word">
	热门练习
	</li>
	<li class="active_tab side_bar_word">
	我的收藏
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