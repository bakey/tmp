<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="user-scalable=no, initial-scale = 1, minimum-scale = 1, maximum-scale = 1, width=device-width" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/static/stylesheets/app.css">
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/static/scripts/library.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/static/scripts/app.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/static/scripts/initialize.js"></script>
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
					$model = LibUser::model()->findByPk(Yii::app()->user->id);
					$avatarCode = ''; 
					if($model->user_profile->avatar != 'default_avatar.jpg'){
						$avatarCode = html_entity_decode(CHtml::image(Yii::app()->request->baseUrl.'/'.Yii::app()->params['uploadFolder'].'/'.$model->id.'/avatar/'.$model->user_profile->avatar,'alt',array('width'=>64,'height'=>64,'alt'=>'avatar')));
					}else{
						$avatarCode = html_entity_decode(CHtml::image(Yii::app()->request->baseUrl.'/images/'.$model->user_profile->avatar,'alt',array('width'=>64,'height'=>64,'alt'=>'avatar')));
					}
					echo $avatarCode;
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
		<?php echo CHtml::image(Yii::app()->request->baseUrl.'/images/rdfz-tile.jpg','alt',array());?>
	</div>
	<div id="dashboard">
	    <div class="scroll con">
	        <div class="section" title="<?php echo CHtml::encode($this->pageTitle); ?>" id="home">
	        	<p>test</p>
	        </div>
	    </div>
	</div>

	<?php 
			$uname = '';
			$uid = -1;
			if(isset(Yii::app()->user->real_name)){
				$uname = Yii::app()->user->real_name;
				$uid = Yii::app()->user->id;
			}
			$is_school_admin = 0 ;//Yii::app()->user->urole == Yii::app()->params['user_role_school_admin'];
			$this->widget('zii.widgets.CMenu',array(
		    	'items'=>array(
			    	array('label'=>'首页', 'url'=>array('/site/index')),
					array('label'=>'课程','items'=>array(
						array('label'=>'课程首页','url'=>array('/teach/course/admin')),
						array('label'=>'教材管理', 'url'=>array('/teach/edition/admin') , 'visible'=>$is_school_admin),
						array('label'=>'教材导入', 'url'=>array('/teach/edition/importedition') , 'visible'=>$is_school_admin),				
						array('label'=>'题库管理', 'url'=>array('/teach/problem') , 'visible'=>$is_school_admin),
						array('label'=>'知识点管理', 'url'=>array('/teach/knowledgepoint') , 'visible'=>$is_school_admin),
						array('label'=>'导入知识点', 'url'=>array('/teach/knowledgepoint/importkp&course_id=1'),'visible'=>$is_school_admin),
					),'active'=>((Yii::app()->controller->id == 'course')||(Yii::app()->controller->id == 'edition')),'visible'=>!Yii::app()->user->isGuest),
					array('label'=>'班级' , 'url'=>array('/user/libclass/admin')),
					array('label'=>'测试', 'url'=>array('/teach/task') ,/*'items'=>array(
						array('label'=>'题库管理', 'url'=>array('/teach/problem')),
						array('label'=>'我的测验' , 'url'=>array('/teach/task/')),
					),*/'active'=>((Yii::app()->controller->id == 'problem') || (Yii::app()->controller->id == 'task')),'visible'=>!Yii::app()->user->isGuest),

					array( 'label'=>'问答',
							'url' => array('/teach/question/myquestion'),/*'items'=>array(
						array('label'=>'我的问答', 'url'=>array('/teach/question/myquestion')),)*/
							'active'=>((Yii::app()->controller->id == 'question')||(Yii::app()->controller->id == 'answer')),
							'visible'=>!Yii::app()->user->isGuest),

					array('label'=>'统计','url'=>array('/teach/statistics/'),'active'=>(Yii::app()->controller->id == 'statistics'),'visible'=>!Yii::app()->user->isGuest),
					array('label'=>'用户相关功能','url'=>array('/user/libuser'),'items'=>array(
							array('label'=>'创建班级', 'url'=>array('/user/libclass/create')),
							array('label'=>'用户注册', 'url'=>array('/user/libuser/register')),
							array('label'=>'从Excel文件导入学生','url'=>array('/user/libuser/importstudentlist'),
									'visible'=>$is_school_admin ),
							array('label'=>'从Excel文件导入教师','url'=>array('/user/libuser/importteacherlist'),
									'visible'=> $is_school_admin ),
							array('label'=>'查看Profile','url'=>array('/user/profile/view','id'=>$uid),
									'visible'=>!Yii::app()->user->isGuest),
							array('label'=>'编辑Profile','url'=>array('/user/profile/update','id'=>$uid),
									'visible'=>!Yii::app()->user->isGuest),
							array('label'=>'邀请教师','url'=>array('/user/libuser/inviteteacher'),
									'visible'=> $is_school_admin ),
							array('label'=>'添加学生','url'=>array('/user/libuser/invitestudent'),
									'visible' => $is_school_admin ),
							array('label'=>'学生状态','url'=>array('/user/libuser/classstustatus')),
							array('label'=>'系统通知发送', 'url'=>array('/user/notification/create')),
						),'visible'=>!Yii::app()->user->isGuest),
						array('label'=>'登陆', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
						array('label'=>'退出系统 ('.$uname.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	
	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</body>
</html>
