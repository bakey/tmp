<?php
/* @var $this DocToPDFController */

$this->breadcrumbs=array(
	'Doc To Pdf'=>array('/docToPDF'),
	'Test',
);
?>
<script type="text/javascript" src="js/swfobject.js"></script>
<div id="myContent">
     <p>没有可用的flash player</p>
</div>
<script type="text/javascript">
swfobject.embedSWF("test.swf", "myContent", "300", "270", "9.0.0");
</script>

<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<p>
	You may change the content of this page by modifying
	the file <tt><?php echo __FILE__; ?></tt>.
</p>
