<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	$this->module->id,
);
?>

<p>
课程查看
</p>
<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	$this->module->id,
);
$this->renderPartial( '_form_show_course' , array('dataProvider'=>$dataProvider));
?>
