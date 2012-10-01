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
echo CHtml::dropDownList( 'list_subject','', $list_subject ,array(
		'empty'=>'请选择科目',
		'ajax' => array(
					'type'=>'POST',
					'url'=>CController::createUrl('index'),
					'data' => array('subject'=>'js:$("#list_subject").val()',),
					'update'=>'#knowledge-point-id',
				),
	)	);
?> 
<div class="well">
<?php
$this->renderPartial('_form_show_kp' , array('dataProvider' => $dataProvider) ); 
?>
</div>
<?php 
$this->renderPartial( '_form_addkp' , array('kp_model' => $kp_model) ); 
?>
