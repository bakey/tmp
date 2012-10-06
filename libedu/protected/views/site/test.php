<?php
/*$this->Widget('ext.highcharts.HighchartsWidget', array(
		'options'=>array(
				'title' => array('text' => 'Fruit Consumption'),
				'xAxis' => array(
						'categories' => array('Apples', 'Bananas', 'Oranges')
				),
				'yAxis' => array(
						'title' => array('text' => 'Fruit eaten')
				),
				'series' => array(
						array('name' => 'Jane', 'data' => array(1, 0, 4)),
						array('name' => 'John', 'data' => array(5, 7, 3))
				)
		)
));*/

$this->widget('application.extensions.redactorjs.Redactor',array(
		'model'=>$model,
		'attribute'=>'post',
		'editorOptions' => array(
				'focus' => false,
				'style' => 'height:10px;',
		),
));

?>
<div style="border-width:thin;border-style:solid;border-color:gray;margin-left:840px ;margin-top:20px;float:right;position:absolute;top:50px;left:350px">
附件上传
</div>

