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
	<a href="index.php?r=teach/task" rel="external">
		<li class="side_bar_head active_tab sail">
		我的练习
		</li>
	</a>
	<li class="side_bar_head active_tab">
	共建练习
	</li>
	<li class="side_bar_head active_tab">
	热门练习
	</li>
	<li class="side_bar_head active_tab">
	我的收藏
	</li>
</ul>
 <div class="tabs">
     <div id="tab_one" class="tab mytab" >
     
     <div class="dotbottom col_12">
     
     	<a href="javascript:void(0)" onclick="show_recent_task_list(event)">		
			<div class="carton col_3 recent_task_tab" >
 				<div id="recent_task_tab" class="subcontent bordered sail">
   				最近练习
 				</div>
			</div>
		</a>   
   		<a href="javascript:void(0)" onclick="show_total_task_list(event)">
       		<div class="carton col_3">
 				<div id="total_task_tab" class="subcontent bordered">
   				全部练习
 				</div>
			</div>
		</a>		
		<a href="javascript:void(0)" onclick="create_task()">
			<div class="carton col_3"  style="width:269px;float:right;margin-right:15px">
 				<div class="subcontent bordered">
 					<span class="iconclass min" style="line-height:17px; font-size:22px;">+</span>
    	 			创建练习
    	 		</div>
    	 	</div>
    	 </a>
    	 </div>
    	<div id="recent_task_list">	 
     		<?php
     			$this->renderPartial( 'recent_task_list' , array('recent_task' => $recent_task ) ); 
     		?>	
     	</div>
     	<div id="total_task_list" style="display:none;">
     	<?php
     		$this->renderPartial( 'total_task_list' , array( /*'total_task' => $total_task ,*/ 'top_items' => $top_items ) ); 
     	?>
     	</div>
	</div>
</div>
