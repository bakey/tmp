<?php
/* @var $this StatisticsController */

$this->breadcrumbs=array(
	'Statistics',
);
?>
<h1>统计页面</h1>
<?php
$this->Widget('ext.highcharts.HighchartsWidget', array(
		'options'=>$options,
		));
?>