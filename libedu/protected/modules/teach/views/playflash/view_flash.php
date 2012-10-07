<script type="text/javascript" src="js/swfobject.js"></script>
<script type="text/javascript" src="js/flexpaper_flash.js"></script>
<div style="position:relative;left:10px;top:10px;">
	  <a id="viewerPlaceHolder" style="width:680px;height:480px;display:block"></a>
	    <script type="text/javascript"> 
				var fp = new FlexPaperViewer(	
						 'FlexPaperViewer',
						 'viewerPlaceHolder', { config : {
						 SwfFile : escape('<?php echo $flash_file_path ; ?>'),
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
						 }});
	        </script>
        </div>
