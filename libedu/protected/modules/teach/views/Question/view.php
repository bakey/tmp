<?php
/* @var $this QuestionController */
/* @var $model Question */

$this->breadcrumbs=array(
	'Questions'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Question', 'url'=>array('index')),
	array('label'=>'Create Question', 'url'=>array('create')),
	array('label'=>'Update Question', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Question', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Question', 'url'=>array('admin')),
);
?>

<h1>View Question #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'owner',
		'item',
		array('name'=>'details','type'=>'html'),
		'create_time',
		'view_count',
	),
)); ?>

<h4><a href="<?php echo Yii::app()->createUrl('/teach/question/answer',array('qid'=>$model->id)); ?>">回答</a> | <?php
	echo CHtml::ajaxLink('显示回答及追问',Yii::app()->createUrl('/teach/question/getallsubelement',array('qid'=>$model->id)),array('update'=>'#answer'.$model->id,'success'=>'js:function(data){$("#answer'.$model->id.'").html(data);$("#answer'.$model->id.'").fadeIn();}')); 
?></h4>

<div id="answer<?php echo $model->id ?>" style="display:none;border:1px solid #f1523a;padding:10px; margin-left:100px;">
	</div>
