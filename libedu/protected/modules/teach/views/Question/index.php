
<?php 
Yii::app()->getClientScript()->scriptMap=array(
										'jquery.js'=>false,
								);
$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_subview',
	'summaryText'=>'',
	'id'=>'questionsgroupbyitemlist',
	'ajaxUpdate'=>true,
	'pager'=>array('htmlOptions'=>array('id'=>uniqid()),),
)); ?>
