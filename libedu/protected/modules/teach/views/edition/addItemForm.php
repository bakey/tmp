<?php
return array(
		//'title'=>'Please provide your login credential',

		'elements'=>array(
				'edi_index'=>array(
						'type'=>'text',
						'maxlength'=>32,
				),
				'content'=>array(
						'type'=>'text',
						'maxlength'=>256,
				),
				'level'=>array(
						'type'=>'text',
						'maxlength'=>16,
				),
				'parent'=>array(
						'type' =>'text',
						'maxlength'=>16,
			   ),
		),
		'buttons'=>array(
				'login'=>array(
						'type'=>'submit',
						'label'=>'增加一章',
				),
		),
);
?>