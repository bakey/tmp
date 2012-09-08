<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	$this->module->id,
);
?>
<h1><?php echo $this->uniqueId . '/' . $this->action->id; ?></h1>

<p>
知识点管理
</p>
<p>
<?php
/*$form = $this->beginWidget('CActiveForm' , array(
			'id'=>'course-form',
			'enableClientValidation'=>true,
			'clientOptions'=>array(
					'validateOnSubmit'=>true,
					)
		));*/
?>
<?php
/*echo $form->dropDownList( 'country_id' , '' , array(
        'A' => '1',
        'B' => '2',)
		);*/
echo "科目: ";
echo CHtml::dropDownList( 'list_course','', $list_course ,
array(
'empty'=>'请选择一门课程',
'ajax' => array(
'type'=>'POST', //request type
'url'=>CController::createUrl('KnowledgePoint/dynamiccities'), //url to call.
//Style: CController::createUrl('currentController/methodToCall')
'update'=>'#city_id', //selector to update
//'data'=>'js:javascript statement' 
))); 
echo " 年级:";
echo CHtml::dropDownList( 'list_grade' , '' , $list_grade ,
		array(
		'empty'=>'全部',
) );
 
//empty since it will be filled by the other dropdown
//echo CHtml::dropDownList('city_id','', array());

?> 
<?php
 $this->widget('zii.widgets.grid.CGridView',
		array('dataProvider'=>$dataProvider)
	);
?>

