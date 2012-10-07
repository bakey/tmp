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

/*$this->widget('application.extensions.redactorjs.Redactor',array(
		'model'=>$model,
		'attribute'=>'post',
		'editorOptions' => array(
				'focus' => false,
				'style' => 'height:10px;',
		),
));
*/
?>
<div style="border-width:thin;border-style:solid;border-color:gray;margin-left:840px ;margin-top:20px;float:right;position:absolute;top:50px;left:350px">
附件上传
</div>
   <div id="myContent">
      <p>Alternative content</p>
    </div>

<script type="text/javascript" src="js/swfobject.js"></script>
<script type="text/javascript" src="js/flexpaper_flash.js"></script>
<div style="position:relative;left:10px;top:20px;">
&nbsp;
	        <a id="viewerPlaceHolder" style="width:680px;height:480px;display:block"></a>
	        
	        <script type="text/javascript"> 
	   
	        	        
			/*	var fp = new FlexPaperViewer(	
						 'FlexPaperViewer',
						 'viewerPlaceHolder', { config : {
						 SwfFile : escape('quicktour.swf'),
						 Scale : 0.6, 
						 ZoomTransition : 'easeOut',
						 ZoomTime : 0.5,
						 ZoomInterval : 0.2,
						 FitPageOnLoad : true,
						 FitWidthOnLoad : false,
						 FullScreenAsMaxWindow : false,
						 ProgressiveLoading : false,
						 MinZoomSize : 0.2,
						 MaxZoomSize : 5,
						 SearchMatchAll : false,
						 InitViewMode : 'Portrait',
						 PrintPaperAsBitmap : false,
						 
						 ViewModeToolsVisible : true,
						 ZoomToolsVisible : true,
						 NavToolsVisible : true,
						 CursorToolsVisible : true,
						 SearchToolsVisible : true,
  						
  						 localeChain: 'en_US'
						 }});*/
	        var flashvars = { };
	         var params = {allowFullScreen:true};
	         var attributes = {};
	        swfobject.embedSWF("quicktour.swf", "myContent", "600", "360", "9.0.0","expressInstall.swf" , flashvars, params, attributes);
	        </script>
        </div>

