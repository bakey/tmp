<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	$this->module->id,
);
?>

<p>
知识点管理
</p>
<p>

<?php
echo "科目: ";
echo CHtml::dropDownList( 'list_course','', $list_course ,
	array(
		'empty'=>'请选择一门课程',
	 )
); 
echo " 年级:";
echo CHtml::dropDownList( 'list_grade' , '' , $list_grade ,
		array(
		//'onchange' => 'js:alert( $("#list_course").val() )',
		'ajax' => array(
			'type'=>'POST',
			'url'=>CController::createUrl('index&school_id=1'),
			'data' => array('course'=>'js:$("#list_course").val()',
				'grade'=>'js:$("#list_grade").val()',
			),
			'update'=>'#knowledge-point-id', //selector to update
		),
		'empty'=>'全部',
) );
?> 

<?php
$this->renderPartial( '_form_showkp' , array('dataProvider' => $dataProvider) );
$this->renderPartial( '_form_addkp' , array('kp_model' => $kp_model) ); 
?>
