<?php
$this->pageTitle=Yii::app()->name;
Yii::app()->getClientScript()->scriptMap=array(
		'jquery.js'=>false,
);
?>
<script type="text/javascript">
function switch_to_tools_content()
{
	$("#apps_course_content").fadeOut();
	$("#apps_tools_content").fadeIn();
	$("#account_tab").removeClass('sail').addClass('carton');
	$("#apps_tab").removeClass('carton').addClass('sail');
}
function switch_to_course_content()
{
	$("#apps_tools_content").fadeOut();
	$("#apps_course_content").fadeIn();
	$("#account_tab").removeClass('carton').addClass('sail');
	$('#apps_tab').removeClass('sail').addClass('carton');
}
$(document).ready(function(){ 
	switch_to_tools_content();
});

</script>
	<div class="libstore_header col_12">
		<h1>
		Libstore
		</h1>
	</div>

<div class="container dotbottom app_tab">
	<a href="javascript:void(0)" onclick="switch_to_course_content()">
		<span id="account_tab" class="col_2 carton" style="height:30px;font-size:20px;" >
			我的账户
		</span>
	</a>
	<a href="javascript:void(0)" onclick="switch_to_tools_content()">
		<span id="apps_tab" class="col_2 carton"  style="height:30px;font-size:20px;">
			应用
		</span>
	</a>
	<div class="col_2">
	<select class="app_filter">
	<option>资料</option>
	<option>数学</option>
	<option>语文</option>
	<option>英语</option>
	<option>物理</option>
	<option>化学</option>
	</select>
	</div>
</div>
<div id="apps_course_content" style="display:none">
	<?php
		$this->renderPartial('apps_course'); 
	?>	
</div>

<div id="apps_tools_content" style="display:none">
<?php
	$this->renderPartial('apps_tool'); 
?>
</div>

