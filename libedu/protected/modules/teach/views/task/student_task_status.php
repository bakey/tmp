<script type="text/javascript">
function switch_fastest_student( element )
{
	$('#unfinish_student').fadeOut(200);
	$('#fastest_finish').fadeIn(200);	
	$( '#fastest_finish_tab' ).addClass('sail');
	$( '#unfinish_tab' ).removeClass('sail');
}
function switch_unfinish_student()
{
	$('#fastest_finish').fadeOut(200);
	$('#unfinish_student').fadeIn(200);	
	$( '#fastest_finish_tab' ).removeClass('sail');
	$( '#unfinish_tab' ).addClass('sail');
}
function closemodal(){
	$('#overlays .modal').fadeOut(100);
	$('#overlays').removeClass();
	$(document).unbind('keyup');	
}
$(document).ready(function(){ 
	switch_fastest_student();
});
</script>
<div class="task_student_finish_status">
<?php 
	echo '本课程共有' . $total_student . '人，已有' . $finish_stu_count . '人完成练习';
?>
</div>
<div class>
	<a href="javascript:void(0)" onclick="switch_fastest_student(this)">
		<div class="carton col_3">	
			<div id="fastest_finish_tab"  class="subcontent bordered" >
   					最先完成的同学
 			</div>
 		</div>
 	</a>
 
 	<a href="javascript:void(0)" onclick="switch_unfinish_student(this)">		
		<div class="carton col_3">	
 			<div id="unfinish_tab"  class="subcontent bordered">
 			未完成的同学
 			</div>
 		</div>
 	</a>
 </div>
 	<div class="task_student_stat" > 	
 		<div id="fastest_finish" style="display:none">
 		<?php
 			if ( count($fastest_finish_student) <= 0 )
 			{
 				echo '暂没有学生完成';
 			} 
 			foreach( $fastest_finish_student as $student )
 			{
 				echo '<span class="carton" style="margin-left:10px">';
 				echo $student->user_profile->real_name;
 				echo '</span>';
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
 	</div>
 	<div class="student_task_stat_cancel_button"> 	
 		<?php
   			echo CHtml::htmlButton('返回' , array('onclick' => 'closemodal()' , 'class' => 'sugar') ) ;
 		?>
 	</div>
 
