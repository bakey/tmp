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
		</ul>
	</div>
	<div id="dashboard" class="login_board">
	    <div class="scroll con">
	        <div class="section current padding" title="<?php echo CHtml::encode($this->pageTitle); ?>" id="home">
	        	<?php echo $content; ?>
	        </div>
	    </div>
	</div>

	<div id="footer">
		<div class="con">
			<p>Copyright &copy; <?php echo date('Y'); ?> by 励博教育.
			<span>All Rights Reserved.</span>
			<span>
			<?php 
			//	echo Yii::powered(); 
			?></span></p>
		</div>
	</div><!-- footer -->

</body>
</html>
