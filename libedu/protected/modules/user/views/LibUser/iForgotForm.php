<?php

	return array(
		'title'=>'请填写您注册时使用的电子邮件地址：',
		'elements'=>array(
			'email'=>array(
				'type'=>'email',
				'maxlength'=>255,
			),
		),
		'buttons'=>array(
			'resendBtn'=>array(
				'type'=>'submit',
				'label'=>'发送重置密码电子邮件',
			),
		)
	);
?>