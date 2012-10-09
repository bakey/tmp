<!DOCTYPE html>
<html lang="en">
<head>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/static/scripts/library.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/static/scripts/base.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/static/scripts/modal.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/static/scripts/initialize.js"></script>
	<meta charset="utf-8">
	<meta name="viewport" content="user-scalable=no, initial-scale = 1, minimum-scale = 1, maximum-scale = 1, width=device-width" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/static/stylesheets/app.css">
</head>
<body>
	<div id="header">
		<ul class="con">
			<li class="dashboard">
				<a href="#home" data-href="#home" rel="external"><?php echo Yii::app()->params['currentSchoolName']; ?>云校园</a>
			</li>
			<li>
				<a href="#" rel="external"><span class="icon">1</span> 个人中心</a>
			</li>
			<li>
				<a href="#" rel="external"><span class="icon">|</span> 课程广场</a>
			</li>		
			<li class="avatar">
				<?php
					/*$model = LibUser::model()->findByPk(Yii::app()->user->id);
					$avatarCode = ''; 
					if($model->user_profile->avatar != 'default_avatar.jpg'){
						$avatarCode = html_entity_decode(CHtml::image(Yii::app()->request->baseUrl.'/'.Yii::app()->params['uploadFolder'].'/'.$model->id.'/avatar/'.$model->user_profile->avatar,'alt',array('width'=>64,'height'=>64,'alt'=>'avatar')));
					}else{
						$avatarCode = html_entity_decode(CHtml::image(Yii::app()->request->baseUrl.'/images/'.$model->user_profile->avatar,'alt',array('width'=>64,'height'=>64,'alt'=>'avatar')));
					}
					echo $avatarCode;*/
				?>
				<ul>
					<li>
						<a href="#">
							<h4>张老师</h4>
						</a>
					</li>
					<li>
						<a href="#">
							<h4>注销</h4>
						</a>
					</li>
				</ul>
			</li>
			<li class="search">
				<input type="text" placeholder="Search" />
				<ul>
					<li>
						<a href="#">
							<h4>Jens Alba</h4>
							<p>Lorem ipsum dolor sit imet smd ddm lksdm lkdsm</p>
						</a>
					</li>
					<li>
						<a href="#">
							<h4>Jens Alba</h4>
							<p>Lorem ipsum dolor sit imet smd ddm lksdm lkdsm</p>
						</a>
					</li>
					<li>
						<a href="#">
							<h4>Jens Alba</h4>
							<p>Lorem ipsum dolor sit imet smd ddm lksdm lkdsm</p>
						</a>
					</li>
				</ul>
			</li>
		</ul>
	</div>
	<div id="stream">
		<?php //echo CHtml::image(Yii::app()->request->baseUrl.'/images/rdfz-tile.jpg','alt',array());?>
		<div class="con">
			<div class="tile" id="hello">
				<h2><span>高一数学</span> </h2>
				<ul class="nav">
					<li class="teacher-avatar">
						<?php
					$model = LibUser::model()->findByPk(Yii::app()->user->id);
					$avatarCode = ''; 
					
					$avatarCode = html_entity_decode(CHtml::image(Yii::app()->request->baseUrl.'/images/test.jpg','alt',array('width'=>36,'height'=>36,'alt'=>'avatar')));
					
					echo $avatarCode;
				?>
					</li>
					<li class="teacher-info">
						<a href="#" rel="external">某某老师</a>
					</li>
					<li class="student-number">
						<a href="#" rel="external">学生 123</a>
					</li>
				</ul>
			</div>

			<a class="tile" rel="external">
				<span class="vector">'</span>
				<span class="title"><strong>课程</strong> </span>
			</a>
			<a class="tile" rel="external">
				<span class="vector">C</span>
				<span class="title"><strong>测试</strong> </span>
			</a>
			<a class="tile" rel="external">
				<span class="vector">f</span>
				<span class="title"><strong>问答</strong> </span>
			</a>
			<a class="tile" rel="external">
				<span class="vector">v</span>
				<span class="title"><strong>统计</strong> </span>
			</a>
			<a class="tile" rel="external">
				<span class="vector">F</span>
				<span class="title"><strong>视频</strong> </span>
			</a>
			<a class="tile" rel="external">
				<span class="vector">+</span>
				<span class="title"><strong>添加应用</strong></span>
			</a>					
		</div>
	</div>
	<div id="dashboard">
	    <div class="scroll con">
	        <div class="section current padding" title="<?php echo CHtml::encode($this->pageTitle); ?>" id="home">
	        	<?php echo $content; ?>
	        </div>
	    </div>
	</div>

	<div id="footer">
		<div class="con">
			<p>Copyright &copy; <?php echo date('Y'); ?> by My Company.
			<span>All Rights Reserved.</span>
			<span><?php echo Yii::powered(); ?></span></p>
		</div>
	</div><!-- footer -->

</body>
</html>
