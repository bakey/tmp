
<h1>用户登录</h1>

<div class="form span9 offset1">
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'type'=>'inline',
	'htmlOptions'=>array('class'=>'well'),
)); ?>


		<?php echo $form->textFieldRow($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>



		<?php echo $form->passwordFieldRow($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'登陆')); ?>

		
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo CHtml::label('自动登陆','LoginForm[rememberMe]'); ?>
	
		<p>
			<a href="<?php echo Yii::app()->createUrl('/user/libuser/iforgot') ?>">忘记密码？</a>
		</p>

		

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

	#registerArea, #mobileClientArea {border:1px solid #16a9f7; overflow: auto; padding: 20px; width:340px; margin-left: 50px; margin-top: 60px; float:left;}
</style>