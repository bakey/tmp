<script type="text/javascript">
function show_task_status( task_id )
{
	$.fn.modal({
		url : '<?php echo Yii::app()->params['index_path']?>?r=teach/task/showstudenttaskstatus&task_id=' + task_id,
    	animation:  "fadeIn"
	});
	
}
</script>
<?php
	foreach( $recent_task as $task )
	{
		echo '<div class="carton col_4 task_list">';
?>
		<span class="check_task_btn">
		<?php echo CHtml::htmlButton('查看练习' , array('onclick' => 'window.location.href="index.php?r=teach/task/previewtask&task_id=' . $task->id . '"') ); ?>
		<?php echo CHtml::htmlButton('查看学生完成情况' , array('onclick' => 'show_task_status(' .$task->id . ')') );?>
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