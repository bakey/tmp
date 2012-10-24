<?php
Yii::app()->getClientScript()->scriptMap=array(
		'jquery.js'=>false,
);
?>
<script type="text/javascript">
function create_task()
{
	$.fn.modal({
		url : '<?php echo Yii::app()->createUrl('/teach/task/newtaskname');?>',
    	/*theme:      "dark",
    	width:      80,
    	height:     40,
    	layout:     "elastic",
    	url:        undefined,
    	content:    "<strong>HTML</strong> content",
    	padding:    "100px",*/
    	animation:  "fadeIn"
	});
}
function show_total_task_list(event)
{
	//$('#recent_task_list').fadeOut( 300 );
	$('#recent_task_list').hide();
	$('#recent_task_tab').removeClass( 'sail' );
	
	$('#total_task_list').show();
	$(event.target).addClass('sail');
}
function show_recent_task_list(event)
{
	if ( $('#total_task_list').css('display') != 'none' )
	{
		//$('#total_task_list').fadeOut( 200 );
		$('#total_task_list').toggle();
		$('#total_task_tab').removeClass('sail');
	}
	if ( $('#recent_task_list').css('display') == 'none' )
	{
		//$('#recent_task_list').fadeIn( 200 );
		$('#recent_task_list').toggle();
		$('#recent_task_tab').addClass( 'sail' );
	}
}
</script>
<ul class="tabs">
	<li class="side_bar_head active_tab">
	我发布的测试
	</li>
	<li class="side_bar_head active_tab">
	学生共建测试
	</li>
	<li class="side_bar_head active_tab">
	热门试卷
	</li>
	<li class="side_bar_head active_tab">
	收藏的试卷
	</li>
</ul>
 <div class="tabs">
     <div id="tab_one" class="tab mytab" >
     
     	<a href="javascript:void(0)" onclick="show_recent_task_list(event)">		
			<div class="carton col_3">
 				<div id="recent_task_tab" class="subcontent bordered sail">
   				最近测试
 				</div>
			</div>
		</a>   
   		<a href="javascript:void(0)" onclick="show_total_task_list(event)">
       		<div class="carton col_3">
 				<div id="total_task_tab" class="subcontent bordered">
   				全部测试
 				</div>
			</div>
		</a>
	

		
		<a href="javascript:void(0)" onclick="create_task()">
			<div class="carton" style="width:31.3%;float:right">
 				<div class="subcontent bordered adrift">
 					<span class="iconclass min">+</span>
    	 			创建测试
    	 		</div>
    	 	</div>
    	 </a>
    	<div id="recent_task_list">	 
     		<?php
     			$this->renderPartial( 'recent_task_list' , array('recent_task' => $recent_task ) ); 
     		?>	
     	</div>
     	<div id="total_task_list" style="display:none">
     	<?php
     		$this->renderPartial( 'total_task_list' , array( /*'total_task' => $total_task ,*/ 'top_items' => $top_items ) ); 
     	?>
     	</div>
	</div>
</div>
