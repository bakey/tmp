


<h1>Update Editions</h1>
<h2>
<?php 
	echo("教材名称 :" . $edition->name . "<br>");
	echo("教材描述 :" . $edition->description . "<br>");
	?>
	</h2>
	<h3>
	目前的章节:
	</h3>
<?php $this->widget('zii.widgets.grid.CGridView',
		array('dataProvider'=>$dataProvider)
	);
?>
<?php

 /*$form=$this->beginWidget('CActiveForm', array(
	'id'=>'item-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
));
*/
 ?>
<p class="note">Fields with <span class="required">*</span> are required.</p>
<div class="form">
<?php echo $form; ?>
	
<?php 
$url = 'edition/ajaxFillTree&edition_id=' . $edition->id;
$this->widget(
	    'CTreeView',
		array(
            'animated'=>'fast', //quick animation
            'collapsed' => false,
            'url' => array( $url ), 
		)
);
?>















