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
				'label'=>'重新发送激活邮件',
			),
		)
	);
?>