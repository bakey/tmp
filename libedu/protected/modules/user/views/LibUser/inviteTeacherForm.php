<?php

	return array(
		'attributes'=>array(
			'class'=>'well',
		),
		'elements'=>array(
			'name'=>array(
				'type'=>'text',
				'label'=>'老师的真实姓名',
				'maxlength'=>255,
				'required'=>true,
			),
			'school_unique_id'=>array(
				'type'=>'email',
				'label'=>'请输入您要邀请老师的电子邮件地址：',
				'maxlength'=>255,
				'required'=>'true',
			),

		),
		'buttons'=>array(
			'resendBtn'=>array(
				'type'=>'submit',
				'label'=>'邀请教师',
				'class' => 'btn',
			),
		)
	);
?>