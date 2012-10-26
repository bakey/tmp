<div id="<?php echo $runOptions['id']; ?>">
    <p>
        To view this page ensure that Adobe Flash Player version 
        10.2.0 or greater is installed. 
    </p>
    <script type="text/javascript"> 
        var pageHost = ((document.location.protocol == "https:") ? "https://" : "http://"); 
        document.write("<a href='http://www.adobe.com/go/getflashplayer'><img src='" 
            + pageHost + "www.adobe.com/images/shared/download_buttons/get_flash_player.gif' alt='Get Adobe Flash player' /></a>" ); 
    </script> 
</div>

<noscript>
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="100%" height="100%" id="<?php echo $runOptions['swfName']; ?>">
    <param name="movie" value="<?php echo $runOptions['swfUrl']; ?>" />
    <param name="quality" value="<?php echo $runOptions['quality']; ?>" />
    <param name="bgcolor" value="<?php echo $runOptions['bgcolor']; ?>" />
    <param name="allowFullScreen" value="<?php echo $runOptions['allowfullscreen']; ?>" />
    <!--[if !IE]>-->
    <object type="application/x-shockwave-flash" data="<?php echo $runOptions['swfUrl']; ?>" width="<?php echo $runOptions['width']; ?>" height="<?php echo $runOptions['height']; ?>">
        <param name="quality" value="<?php echo $runOptions['quality']; ?>" />
        <param name="bgcolor" value="<?php echo $runOptions['bgcolor']; ?>" />
        <param name="allowFullScreen" value="<?php echo $runOptions['allowfullscreen']; ?>" />
        <!--<![endif]-->
        <!--[if gte IE 6]>-->
        <p> 
            Either scripts and active content are not permitted to run or Adobe Flash Player version
            10.2.0 or greater is not installed.
        </p>
        <!--<![endif]-->
        <a href="http://www.adobe.com/go/getflashplayer">
            <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash Player" />
        </a>
        <!--[if !IE]>-->
    </object>
    <!--<![endif]-->
</object>
</noscript>

<script type="text/javascript">
    var swfVersionStr = "10.2.0";
    var xiSwfUrlStr = "playerProductInstall.swf";
    var flashvars = {};
<?php if (isset($runOptions['streamURL'])) { ?>
        flashvars.streamURL  ="<?php echo $runOptions['streamURL']; ?>";
<?php } ?>
<?php if (isset($runOptions['streamName'])) { ?>
        flashvars.streamName ="<?php echo $runOptions['streamName']; ?>";
<?php } ?>
<?php if (isset($runOptions['richMediaURL'])) { ?>
        flashvars.richMediaURL  ="<?php echo $runOptions['richMediaURL']; ?>";
<?php } ?>
    var params = {};
    params.quality = "<?php echo $runOptions['quality']; ?>";
    params.bgcolor = "<?php echo $runOptions['bgcolor']; ?>";
    params.allowfullscreen = "<?php echo $runOptions['allowfullscreen']; ?>";
        
    var attributes = {};
    attributes.id = "<?php echo $runOptions['swfName']; ?>";
    attributes.name = "<?php echo $runOptions['swfName']; ?>";
    attributes.align = "<?php echo $runOptions['align']; ?>";
    swfobject.embedSWF(
    "<?php echo $runOptions['swfUrl']; ?>", "<?php echo $runOptions['id']; ?>", 
    "<?php echo $runOptions['width']; ?>", "<?php echo $runOptions['height']; ?>", 
    swfVersionStr, xiSwfUrlStr, 
    flashvars, params, attributes);
    // JavaScript enabled so display the flashContent div in case it is not replaced with a swf object.
    swfobject.createCSS("#<?php echo $runOptions['id']; ?>", "display:block;text-align:left;");
</script>