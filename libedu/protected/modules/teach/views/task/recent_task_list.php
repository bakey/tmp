<?php
	foreach( $recent_task as $task )
	{
		echo '<div class="carton col_4 task_list">';
?>
		<span style="float:right">
			<button>查看学生完成情况</button>
		</span>
		<span style="float:right">
			<button>查看练习</button>
		</span>

		<div class="task_info">
			<?php 
				echo $task->name;
			?>		
			<div class>
			<?php
				$date_array = explode( ' ' , $task->create_time );
				echo '发布日期:' . $date_array[0] ;			 
			?>
			</div>
		</div>
<?php 
		echo '</div>';		
	}
?>