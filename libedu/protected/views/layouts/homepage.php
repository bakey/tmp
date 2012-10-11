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
			<li class="siteindex">
				<a href="<?php echo Yii::app()->createUrl('/site/index'); ?>" data-href="#home" rel="external"><?php echo Yii::app()->params['currentSchoolName']; ?>云校园</a>
			</li>
			<li class="userhome">
				<a href="<?php echo Yii::app()->createUrl('/user/libuser/home'); ?>" rel="external"><span class="icon">1</span> 个人中心</a>
			</li>
			<li>
				<a href="#" rel="external"><span class="icon">|</span> 课程广场</a>
			</li>		
			<li class="avatar">
				<?php
					$model = LibUser::model()->findByPk(Yii::app()->user->id);
					$avatarCode = ''; 
					if ( null != $model )
					{ 
						$user_profile = $model->user_profile;
						if ( null == $user_profile ) {
							$avatarCode = "";
						}else if ( $user_profile->avatar != 'default_avatar.jpg' ) {
							$avatarCode = html_entity_decode(CHtml::image(Yii::app()->request->baseUrl.'/'.Yii::app()->params['uploadFolder'].'/'.$model->id.'/avatar/'.$model->user_profile->avatar,'alt',array('width'=>64,'height'=>64,'alt'=>'avatar')));
						}else {
							$avatarCode = html_entity_decode(CHtml::image(Yii::app()->request->baseUrl.'/images/'.$model->user_profile->avatar,'alt',array('width'=>64,'height'=>64,'alt'=>'avatar')));
						}
						echo $avatarCode ;
					}else{
						echo $avatarCode;
					}
					echo '<ul>
					<li>
						<a href="'.Yii::app()->createUrl('/user/profile/view',array('id'=>$model->id)).'" rel="external">
							<h4>'.$model->user_profile->real_name;
				?>
				</h4>
						</a>
					</li>
					<li>
						<a href="index.php?r=site/logout">
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
	<div id="dashboard" class="home_board">
	    <div class="scroll con">
	        <div class="section current" title="<?php echo CHtml::encode($this->pageTitle); ?>" id="home">
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
