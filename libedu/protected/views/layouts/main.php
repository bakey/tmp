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
			$is_school_admin = 0 ;//Yii::app()->user->urole == Yii::app()->params['user_role_school_admin'];
			$this->widget('bootstrap.widgets.TbNavbar',array(
			'items'=>array(
		    	array(
		    		'class'=>'bootstrap.widgets.TbMenu',
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
						
						array('label'=>'测试', 'url'=>array('/teach/task') ,/*'items'=>array(
							array('label'=>'题库管理', 'url'=>array('/teach/problem')),
							array('label'=>'我的测验' , 'url'=>array('/teach/task/')),
						),*/'active'=>((Yii::app()->controller->id == 'problem') || (Yii::app()->controller->id == 'task')),'visible'=>!Yii::app()->user->isGuest),

						array( 'label'=>'问答',
								'url' => array('/teach/question/myquestion'),/*'items'=>array(
							array('label'=>'我的问答', 'url'=>array('/teach/question/myquestion')),)*/
								'active'=>((Yii::app()->controller->id == 'question')||(Yii::app()->controller->id == 'answer')),
								'visible'=>!Yii::app()->user->isGuest),

						array('label'=>'统计','url'=>'/','active'=>(Yii::app()->controller->id == 'statistics'),'visible'=>!Yii::app()->user->isGuest),
					),
				),

				array(
		    		'class'=>'bootstrap.widgets.TbMenu',
	                'htmlOptions'=>array('class'=>'pull-right'),
			    	'items'=>array(
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
				),	
			),
		)); ?>
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	
	<div id="sitefooter" class="footer" style="border-top:1px solid #eee; padding-top:10px;text-align:center;">
			<h6>Copyright &copy; <?php echo date('Y'); ?> by My Company. All Rights Reserved.</h6>
		    <p><?php echo Yii::powered(); ?></p>

	</div><!-- footer -->
</div><!-- page -->

</body>
</html>
