<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/clear.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main_layout.css"/>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>



<div class="container" id="page">
	<?php 
			$uname = '';
			$uid = -1;
			if(isset(Yii::app()->user->real_name)){
				$uname = Yii::app()->user->real_name;
				$uid = Yii::app()->user->id;
			}
			$this->widget('bootstrap.widgets.TbNavbar',array(
		    'items'=>array(
		    	array(
			    	'class'=>'bootstrap.widgets.TbMenu',
			    	'items'=>array(
				    	array('label'=>'首页', 'url'=>array('/site/index')),
						array('label'=>'课程管理', 'url'=>array('/teach/course/admin'),'items'=>array(
							array('label'=>'教材管理', 'url'=>array('/teach/edition/admin')),
						array('label'=>'教材导入', 'url'=>array('/teach/edition/importedition')),				
						array('label'=>'题库管理', 'url'=>array('/teach/problem')),
						array('label'=>'知识点管理', 'url'=>array('/teach/knowledgepoint')),
						array('label'=>'测验管理' , 'url'=>array('teach/task/')),
						array('label'=>'提问', 'url'=>array('/teach/question/create')),
						array('label'=>'导入知识点', 'url'=>array('/teach/knowledgepoint/importkp&course_id=1')),
						)),
						array('label'=>'系统通知发送', 'url'=>array('/user/notification/create')),

						array('label'=>'用户相关功能','url'=>array('/user/libuser'),'items'=>array(
							array('label'=>'创建班级', 'url'=>array('/user/libclass/create')),
							array('label'=>'用户注册', 'url'=>array('/user/libuser/register')),
							array('label'=>'从Excel文件导入学生','url'=>array('/user/libuser/importstudentlist')),
							array('label'=>'从Excel文件导入教师','url'=>array('/user/libuser/importteacherlist')),
							array('label'=>'查看Profile','url'=>array('/user/profile/view','id'=>$uid),'visible'=>!Yii::app()->user->isGuest),
							array('label'=>'编辑Profile','url'=>array('/user/profile/update','id'=>$uid),'visible'=>!Yii::app()->user->isGuest),
							array('label'=>'邀请教师','url'=>array('/user/libuser/inviteteacher')),
							array('label'=>'添加学生','url'=>array('/user/libuser/invitestudent')),
							array('label'=>'学生状态','url'=>array('/user/libuser/classstustatus')),
							array('label'=>'登陆', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
						array('label'=>'退出系统 ('.$uname.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
						)),
					),
				),	
			),
		)); ?>
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer" class="span12">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->
</div><!-- page -->

</body>
</html>
