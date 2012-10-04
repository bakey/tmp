<?php
/* @var $this StatisticsController */

$this->breadcrumbs=array(
	'我的统计'=>array('index'),
);
?>
<h1>统计页面</h1>
<?php
$this->Widget('ext.highcharts.HighchartsWidget', array(
		'options'=>$options,
		));
?>