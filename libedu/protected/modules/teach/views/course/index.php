<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	$this->module->id,
);
?>


<?php
echo(Yii::app()->user->real_name . ",");
echo("我的课程: " ); 
?>
<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	$this->module->id,
);
$this->renderPartial( '_form_show_course' , array('dataProvider'=>$dataProvider));
?>
