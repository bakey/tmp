<script type="text/javascript">
function switch_fastest_student()
{
	$('#fastest_finish').show();
}
</script>
<div class="task_student_finish_status">
<?php 
	echo '本课程共有' . $total_student . '人，已有' . $finish_stu_count . '人完成练习';
?>
</div>
<div class>
	<a href="javascript:void(0)" onclick="switch_">
		<div class="carton col_3">	
			<div class="subcontent bordered">
   					最先完成的同学
 			</div>
 		</div>
 	</a>
 
 	<a href="javascript:void(0)" onclick="">		
		<div class="carton col_3">	
 			<div class="subcontent bordered">
 			未完成的同学
 			</div>
 		</div>
 	</a>
 </div>
 		<div id="fastest_finish" style="display:none">
 		<?php
 			foreach( $fastest_finish_student as $student )
 			{
 				echo $student->user_profile->real_name;
 			} 
 		?>
 		</div>
 		<div id="unfinish_student" style="display:none">
 		<?php
 			foreach( $unfinish_student as $student )
 			{
 				echo $student->user_profile->real_name; 				
 			} 
 		?>
 		</div>

 <?php
   echo CHtml::htmlButton('返回') 
 ?>
