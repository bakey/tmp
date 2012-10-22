<?php
$this->breadcrumbs=array(
	'题库管理',
);

$this->menu=array(
	array('label'=>'Create Problem', 'url'=>array('create')),
	array('label'=>'Manage Problem', 'url'=>array('admin')),
);
?>

<h1>所有问题</h1>
<div class="well">
<?php 

$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
));
?>
</div>
<?php 
echo $this->renderPartial('_form_add_problem', array( 
										'model'=>$problem ,
										'subjectList'=>$subjectList,
 									)
		);
 ?>

<?php
//echo $this->renderPartial('_form_add_problem', array('model'=>$problem)); 
 ?>
