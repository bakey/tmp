<?php

	return array(
		'attributes'=>array(
			'class'=>'well',
		),
		'elements'=>array(
			'email'=>array(
				'type'=>'email',
				'maxlength'=>255,
				'attributes'=>array('class'=>'span5'),
			),
		),
		'buttons'=>array(
			'resendBtn'=>array(
				'type'=>'submit',
				'label'=>'重新发送激活邮件',
				'attributes'=>array('class'=>'btn'),
			),
		)
	);
?>