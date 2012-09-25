<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - 登陆';
$this->breadcrumbs=array(
	'Login',
);
?>

<h1>用户登录</h1>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<div class="row">
		<?php echo CHtml::label('电子邮箱','LoginForm[username]',array('required'=>true)); ?>
		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo CHtml::label('密码','LoginForm[password]',array('required'=>true)); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row rememberMe">
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo CHtml::label('自动登陆','LoginForm[rememberMe]'); ?>
		<?php echo $form->error($model,'rememberMe'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('登陆'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->


<div id="registerArea">
	<h3>现在注册</h3>
	<?php echo CHtml::button('我是学生'); ?>
	<?php echo CHtml::button('我是老师'); ?>
	<?php echo CHtml::button('我是家长'); ?>
</div>

<div id="mobileClientArea">
	<h3>移动客户端</h3>
	<ul>
		<li>iOS</li>
		<li>Android</li>
	</ul>
</div>

<style>
	.form {border:1px solid #16a9f7; overflow: auto; padding: 20px; width:500px; margin-left: 200px;}
	.form .row{float:left;}
	.form .row.buttons{clear:both;}

	#registerArea, #mobileClientArea {border:1px solid #16a9f7; overflow: auto; padding: 20px; width:340px; margin-left: 50px; margin-top: 60px; float:left;}
</style>