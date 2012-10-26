<script type="text/javascript">
function select_item( event , item_id )
{
	var input_node = '<input name="Item[]" class="selected_item_name" value="' + item_id + '">' + $('#' + item_id).text();
	input_node += '</input>';
	$('#item_selected').append( input_node );
	$('#item_select_hint').html('您选择了章节：' + $('#item_selected').text());
	
}
function closemodal(){
	$('#overlays .modal').fadeOut(100);
	$('#overlays').removeClass();
	$(document).unbind('keyup');	
}
</script>
<div class="carton tinyallpadding animated fadeIn">
	<h2>选择章节</h2>
	<div class="content">
	<?php
		Yii::app()->getClientScript()->scriptMap=array(
										'jquery.js'=>false,
								);
		$url = 'task/ajaxLoadItem&edition_id='.$edi_model->id ;
		$this->widget(
			    'CTreeView',
				array(
					'id'=>'modaltreeview',
		            'animated'=>'fast', 
		            'collapsed' => false,
		            'unique'=>true,
		            'url' => array( $url ),
		            //'toggle'=>'js:function(){$(this).parents(".modal").css("height",parseInt($(this).parents("#modaltreeview").height())+280+"px");}',
				)
		);
?>
		<div class="carton col_12 roundbordered tinytinyallpadding" id="item_select_hint">请选择一个章节</div>
		<div class="container normaltoppadding">
			<button class="col_4 offset_5 sugar" onclick="submit_task_form(<?php echo $task_id ; ?>)">发布测试</button>
			<button class="col_3 sugar" onclick="closemodal();">取消</button>
		</div>
	</div>
</div>