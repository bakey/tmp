<?php
$this->breadcrumbs=array(
	'Manage edition',
);
?>
<h1>教材管理</h1>

<?php
echo "科目: ";
echo CHtml::dropDownList( 'subject_list','', $subject_list ,
	array(
		'ajax' => array(
				'type' => 'POST' , 
				'url' => CController::createUrl('admin'),
				'data' => array(
						'subject' => 'js:$("#subject_list").val()',
						'grade' => 'js:$("#grade_list").val()',
				),
				'update'=>'#course-editions-id',
		),
	 )
); 
echo " 年级:";
echo CHtml::dropDownList( 'grade_list' , '' , $grade_list ,
		array(
			//	'empty'=>'全部',
				'ajax' => array(
					'type'=>'POST',
					'url'=>CController::createUrl('admin'),
					'data' => array(
						'subject'=>'js:$("#subject_list").val()',
						'grade'=>'js:$("#grade_list").val()',
					),
					'update'=>'#course-editions-id', //selector to update
			),
			//'onchange' => 'js:alert( $("#list_course").val() )',
));
?> 

<?php
$this->renderPartial('_form_show_edition', array( 'dataProvider'=>$dataProvider ) );
$this->renderPartial('_form_add_edition' , array( 'model'=>$model,)	); 
?>