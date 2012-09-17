<?php
/* @var $this UserController */
/* @var $data User */
?>

<div class="view">
	<h3><?php echo $data['姓名'];?></h4>
	<h5>请用以下信息注册加入LibSchool</h5>
	<ul>
		<li>学号：<?php echo $data['学号'];?></li>
		<li>班级：<?php echo $data['班级'];?></li>
	</ul>
</div>