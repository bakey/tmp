<?php
	return array(
		'elements'=>array(
			'name'=>array(
				'type'=>'text',
				'label'=>'姓名',
				'maxlength'=>255,
			),
			'school_unique_id'=>array(
				'type'=>'text',
				'label'=>'学号',
				'maxlength'=>255,
			),
			'class_id'=>array(
				'type'=>'dropdownlist',
				'items'=>CHtml::listData(LibClass::model()->findAll(array('condition'=>'school_id='.Yii::app()->params['currentSchoolID'])), 'id', 'name'),
				'label'=>'班级',
				'maxlength'=>255,
			),

		),
		'buttons'=>array(
			'resendBtn'=>array(
				'type'=>'submit',
				'label'=>'添加学生',
			),
		)
	);
?>