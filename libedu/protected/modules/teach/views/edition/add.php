<?php
/* @var $this EditionController */

$this->breadcrumbs=array(
	'Edition',
);
?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>
<?php
$this->renderPartial('_form_addedition' , array(
			'model'=>$model,)
	); 
?>
