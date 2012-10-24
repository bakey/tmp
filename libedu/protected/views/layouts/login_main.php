<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="user-scalable=no, initial-scale = 1, minimum-scale = 1, maximum-scale = 1, width=device-width" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<title>Dashboard</title>
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/static/stylesheets/app.css">
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/static/scripts/library.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/static/scripts/login.js"></script>
</head>
<body>
	<!--Log in screen-->
	<div id="welcome">
		<div id="users">
			<a href="#" class="plus">Add a user</a>
			<a href="#" class="plus">Add a user</a>
			<div id="avatars">
				<a data-avatar="static/images/boy_avatar.jpg" href="#" class="avatar pin"></a>
			</div>
		</div>
			<?php echo $content; ?>
	</div>
</body>
</html>