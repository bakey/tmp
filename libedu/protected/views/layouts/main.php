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
			<li class="dashboard siteindex">
				<a href="<?php echo Yii::app()->createUrl('/site/index'); ?>" data-href="#home" rel="external"><?php echo Yii::app()->params['currentSchoolName']; ?>云校园</a>
			</li>
			<li>
				<a href="#" rel="external"><span class="icon">1</span> 个人中心</a>
			</li>
			<li>
				<a href="course_square/index.html" rel="external"><span class="icon">|</span>课程广场</a>
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
					}
					echo $avatarCode;
					echo '<ul>
					<li>
						<a href="'.Yii::app()->createUrl('/user/profile/view',array('id'=>$model->id)).'" rel="external">
							<h4>'.$model->user_profile->real_name;
					if ( LibUser::is_teacher() ) {
						echo '老师';
					}
					else if ( LibUser::is_student() ) {
						echo '同学';
					}
				?>
							</h4>
						</a>
					</li>
					<li>
						<a href="index.php?r=site/logout" rel="external">
							<h4>注销</h4>
						</a>
					</li>
				</ul>
			</li>
			<li class="search">
				<input type="text" placeholder="Search" />
			</li>
		</ul>
	</div>
	<?php
		$course_model = null;
		if ( isset(Yii::app()->user->course) )
		{
			$course_model = Course::model()->findByPk( Yii::app()->user->course );
		//	echo $course_model->name;
		}
	?>
	<div id="stream">
		<div class="con">
			<div class="tile" id="hello">
			<a rel="external" href="index.php?r=teach/course/update&course_id=<?php if ( $course_model != null ) { echo $course_model->id ; } ?>">
				<h2><span style="text-decoration:none !important;">
				<?php
				if ( null != $course_model )
				{
					echo $course_model->name;
				}
				?>
				</span> </h2>
				</a>
				<ul class="nav">
					<li class="teacher-avatar">
						<?php
						$avatarCode = "";
						if ( isset(Yii::app()->user->course) )
						{
							$course_model = Course::model()->findByPk( Yii::app()->user->course );
							$teacher_user_model = $course_model->getCourseTeacher();
							if ( null != $teacher_user_model )
							{
								$avatar_name = $teacher_user_model->user_profile->avatar;
								if ( $avatar_name != 'default_avatar.jpg' ) {
									$avatarCode = html_entity_decode(CHtml::image(Yii::app()->request->baseUrl.'/'.Yii::app()->params['uploadFolder'].'/'.$teacher_user_model->id.'/avatar/'.$avatar_name,'avatar',array('width'=>36,'height'=>36)));
								}else {
									$avatarCode = html_entity_decode(CHtml::image(Yii::app()->request->baseUrl.'/images/'.$avatar_name,
																'avatar',array('width'=>36,'height'=>36)));
								}
							}
						}
						echo $avatarCode;
				?>
					</li>
					<li class="teacher-info">
						<?php
							if ( LibUser::is_teacher() )
							{
								echo $teacher_user_model->user_profile->real_name . '老师';
							}
							else if ( LibUser::is_student() )
							{
								echo '任课老师<br>' . $teacher_user_model->user_profile->real_name ;
							}						
						?>
					</li>
					<li class="student-number" style="text-align:center">
						学生 : 
						<?php
							if ( isset( Yii::app()->user->course ) )
							{
								$course_model = Course::model()->findByPk( Yii::app()->user->course );
								echo $course_model->getCourseStudentCount();
							}
						?>
					</li>
					
				</ul>
			</div>

			<?php
				if ( isset( Yii::app()->user->course) ) {
					if ( $this->getId() == "course" || $this->getId() == "coursepost")
						$anchor = sprintf('<a data-href="index.php?r=teach/course/update&course_id=%d" class="tile sail" rel="external">' , Yii::app()->user->course);
					else 
						$anchor = sprintf('<a data-href="index.php?r=teach/course/update&course_id=%d" class="tile" rel="external">' , Yii::app()->user->course);
					
				}
				else {
					$anchor = sprintf('<a data-href="index.php?r=teach/course/admin" class="tile" rel="external">');
				}	
				echo $anchor;
			?>
				<span class="vector count" data-count="7">'</span>
				<span class="title">
					<strong>资料</strong> 
				</span>
			</a>
			<?php
			if ( $this->getId() == 'task' ) {
				echo '<a data-href="index.php?r=teach/task" class="tile sail" rel="external" >' ;
			} 
			else {
				echo '<a data-href="index.php?r=teach/task" class="tile" rel="external" >' ;
			}
			?>
				
				<span class="vector count" data-count="4">C</span>
				<span class="title"><strong>练习</strong> </span>
			</a>
			<?php
				if ( $this->getId() == 'question' ) {
					echo '<a href="index.php?r=teach/question/myquestion" class="tile sail" rel="external" >' ;
				} 
				else {
					echo '<a href="index.php?r=teach/question/myquestion" class="tile" rel="external" >' ;
				}
			?>
				<span class="vector count" data-count="8">f</span>
				<span class="title"><strong>问答</strong> </span>
			</a>
				<?php
				if ( $this->getId() == 'statistics' ) {
					echo '<a href="index.php?r=teach/statistics" class="tile sail" rel="external">' ;
				} 
				else {
					echo '<a href="index.php?r=teach/statistics" class="tile" rel="external">' ;
				}
			?>
			
				<span class="vector">v</span>
				<span class="title"><strong>统计</strong> </span>
			</a>
			<?php
				if ( $this->getId() == 'video' ) {
					echo '<a href="index.php?r=teach/video" class="tile sail" rel="external">' ;
				} 
				else {
					echo '<a href="index.php?r=teach/video" class="tile" rel="external">' ;
				}
			?>
				<span class="vector count" data-count="10">F</span>
				<span class="title"><strong>视频</strong> </span>
			</a>
			<?php
				if ( isset(Yii::app()->controller->module) && Yii::app()->controller->module->id == "app" ) {
					echo '<a href="index.php?r=app/default" class="tile sail" rel="external">';
				}
				else {
					echo '<a href="index.php?r=app/default" class="tile" rel="external">';
				}
			?>
				<span class="vector">+</span>
				<span class="title"><strong>添加应用</strong></span>
			</a>					
		</div>
	</div>
	<div id="dashboard">
	    <div class="scroll con extend_bottom">
	        <div class="section current padding" title="<?php echo CHtml::encode($this->pageTitle); ?>">
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
