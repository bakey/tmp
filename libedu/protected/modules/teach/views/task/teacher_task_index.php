<?php
Yii::app()->getClientScript()->scriptMap=array(
		'jquery.js'=>false,
);
?>
<script type="text/javascript">
function create_task()
{
	$.fn.modal({
		url : '<?php echo Yii::app()->params['index_path']?>?r=teach/task/newtaskname',
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
</script>
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
   
   <a href="javascript:void(0)" onclick="">
       	<div class="carton col_3">
 			<div class="subcontent bordered">
   				全部测试
 			</div>
		</div>
	</a>
	
	<a href="javascript:void(0)" onclick="">		
		<div class="carton col_3">
 			<div class="subcontent bordered">
   				最近测试
 			</div>
		</div>
	</a>
		
		<a href="javascript:void(0)" onclick="create_task()">
			<div class="carton" style="width:31.3%;float:right">
 				<div class="subcontent bordered">
 				<span class="iconclass min">+</span>
    	 			创建测试
    	 		</div>
    	 	</div>
    	 </a>
     <?php
     	$this->renderPartial( 'recent_task_list' , array('recent_task' => $recent_task ) ); 
     ?>
	
	</div>
</div>
