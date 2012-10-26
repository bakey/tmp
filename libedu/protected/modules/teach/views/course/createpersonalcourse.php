<div class="carton col_12">
	<h2>创建课程</h2>
	<div class="col_8 offset_2 stepindicator" style="padding-left:30px" id="stepcontainer">
		<div class="col_4 stepitem selected">
			<p>基本信息</p>
		</div>

		<div class="col_4 stepitem">
			<p>权限设置</p>
		</div>

		<div class="col_4 stepitem">
			<p>教学大纲</p>
		</div>
	</div>
	<div class="carton col_11 roundbordered normalbottommargin stepoutercontainer" style="margin-left:5%;" id="step-1">
		<h2>课程基本信息</h2>
		<div class="col_12">
			<h4>标题</h4>
			<input type="text"  />
			<h4>分类</h4>
			<select id="subjectselection">
				<?php
					foreach($subject as $singlesubject){
						echo '<option value="'.$singlesubject->id.'">'.$singlesubject->name.'</option>';
					}
				?>
			</select>
			<script type="text/javascript">
				$("#subjectselection").chosen();
			</script>
			<h4>简介</h4>
			<textarea type="text"  />
		</div>
	</div>

	<div class="carton col_11 roundbordered normalbottommargin stepoutercontainer" style="margin-left:5%; display:none;" id="step-2">
		<h2>课程权限设置</h2>
		<div class="col_12">
				<div class="col_12">
					<fieldset>
						<legend>课程价格</legend>
					<button class="col_3 offset_2" onclick="choosecourseoption(event)">免费</button>
					<button class="col_3 offset_1" onclick="choosecourseoption(event)">收费</button>
					<div class="col_8 offset_3 coursefeeoption" style="display:none">
						<p>您的课程将免费</p>
					</div>
					<div class="col_8 offset_3 coursefeeoption" style="display:none">
						<p>您的定价是 <input type="text" /></p>
						
					</div>
				</fieldset>
				</div>
				<div class="col_12">
					<fieldset>
						<legend>课程权限</legend>
					<button class="col_3 offset_2" onclick="choosecourseoption(event)">公开</button>
					<button class="col_3 offset_1" onclick="choosecourseoption(event)">不公开</button>
					<div class="col_8 offset_3 coursefeeoption" style="display:none">
						<p>您的课程将公开</p>
					</div>
					<div class="col_8 offset_3 coursefeeoption" style="display:none">
						<p><input type="radio" />仅限我的邀请</p>
						<p><input type="radio" />设定密码 <input type="text" /></p>
					</div>
					</fieldset>
				</div>
		</div>
	</div>

	<div class="carton col_11 roundbordered normalbottommargin stepoutercontainer" style="margin-left:5%; display:none;" id="step-3">
		<h2>安排您的教学大纲</h2>
		<ul class="">
			<li>
				<p>第一章 点击可以编辑章名<p>
				<ul>
					<li><p>第一节 点击可以编辑节名</p></li>
					<li><span>添加节</span></li>
				</ul>
			</li>
			<li>
				<span>添加章</span>
			</li>
		</ul>
	</div>
	<button id="nextbtn" class="col_3 offset_9" onclick="changetonextstep()">下一步</button>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('#step-3.stepoutercontainer p').bind('click',function(event){changedisplayname(event)});
	});

	function changedisplayname(event){
		//alert($(event.target).text());
		var newt = window.prompt('a','b');
		$(event.target).text(newt);
	}

	function changetonextstep(){
		var cstep = $('#stepcontainer').children('.stepitem.selected').index();
		$('#stepcontainer').children('.stepitem').removeClass('selected');
		if(cstep <= 1){
			$('#stepcontainer').children('.stepitem').eq(cstep+1).addClass('selected')
			$('#step-'+(cstep+2)).siblings('.stepoutercontainer').hide();
			$('#step-'+(cstep+2)).fadeIn();
		}
		if(cstep == 1){
			$('#nextbtn').attr('onclick','closemodal()');
			$('#nextbtn').html('完成');
		}
	}

	function choosecourseoption(event){
		var cindex = $(event.target).index();
		cindex --;
		$(event.target).siblings('button').removeClass('sugar');
		$(event.target).addClass('sugar');
		$(event.target).siblings('.coursefeeoption').hide();
		$(event.target).siblings('.coursefeeoption').eq(cindex).fadeIn();
	}
</script>