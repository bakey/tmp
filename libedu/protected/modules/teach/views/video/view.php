<?php
	$baseUrl = Yii::app()->baseUrl; 
	$cs = Yii::app()->getClientScript();
	$cs->scriptMap=array(
	        'jquery.js'=>false,
	);
	$cs->registerScriptFile($baseUrl.'/js/jp/inc/jquery.ui.core.min.js');
	$cs->registerScriptFile($baseUrl.'/js/jp/inc/jquery.ui.widget.min.js');
	$cs->registerScriptFile($baseUrl.'/js/jp/inc/jquery.ui.mouse.min.js');
	$cs->registerScriptFile($baseUrl.'/js/jp/inc/jquery.ui.draggable.min.js');
	$cs->registerScriptFile($baseUrl.'/js/jp/inc/wColorPicker.js');
	$cs->registerCssFile($baseUrl.'/js/jp/wPaint.css');
	$cs->registerCssFile($baseUrl.'/js/jp/inc/wColorPicker.css');
	$cs->registerScriptFile($baseUrl.'/js/jp/wPaint.js');
?>

<script type="text/javascript">
function changeToTabByIndex(event,targettabindex) {
	var index = $(event.target).index();
	index = targettabindex;
	var carton = $(event.target).parent().parent().parent().parent();
	
	carton.children("ul").children("li.current").removeClass("current");
	carton.children("ul").children("li").eq(index).addClass("current");
	
	carton.children(".content.current").removeClass("current");
	carton.children(".content").eq(index).addClass("current");
	carton.slideDown();
	$(event.target).parent().parent().siblings().children(".carton").children(".subcontent").removeClass('sail');
	$(event.target).addClass('sail');

	if(targettabindex == 0){
		$( "._wPaint_menu" ).hide();
	}
	
	if(targettabindex == 1){
		$( "._wPaint_menu" ).fadeIn();
		$( "._wPaint_menu" ).css('top','370px');
		$( "._wPaint_menu" ).css('left','700px');
		$("._wPaint_icon._wPaint_pencil").click();
	}

}

function closemodal(){
			$('#overlays .modal').fadeOut(100);
			$('#overlays').removeClass();
			$(document).unbind('keyup');	
}


</script>

<div class="col_12 dotbottom">
	<h1 style="text-align:center !important;">正弦函数视频面授讲座</h1>
	<div class="col_3">
		<p>计时:<span>13:34</span></p>
	</div>
	<div class="col_5">
		<p>主讲时间: <?php echo date("Y-m-d H:i:s") ?> - <?php echo date("H:i:s",time()+(60*60*2)) ?> 听课密码: 123456</p>
	</div>
	<div class="col_4">
		<button>编辑课程信息</button>
		<button>开始上课</button>
	</div>
</div>

<div class="carton col_12 nobackground">

<div class="container dotbottom normaltoppadding" id="videomenu">
						<a href="javascript:void(0);" onclick="changeToTabByIndex(event,0)" rel="external"><div class="carton col_3">
							<div class="subcontent bordered sail">
								视频
							</div>
						</div></a>

						<a href="javascript:void(0);" onclick="changeToTabByIndex(event,1)" rel="external"><div class="carton col_3">
							<div class="subcontent bordered">
								白板
							</div>
						</div></a>
					</div>

<div class="content animated fadeInLeft tinyallpadding" id="recentquestions" style="min-height:200px;">
					<div class="container tinytinyallpadding">
						<img id="courseimage" src="<?php echo $baseUrl;?>/images/sin.jpg" />
					</div>
				</div>
				<div class="content animated fadeInLeft tinytinyallpadding">
					<div class="container tinytinyallpadding">
						<div id="painter" class="bordered" style="height:300px; width:1000px; background-color:#fff;">
						
						</div>
					</div>
				</div>
</div>

<div class="carton col_12">
	<div class="col_8">
		<div class="col_3">
			<img src="<?php echo $baseUrl;?>/images/default_avatar.jpg"  width="100%" height="100%" />
		</div>
		<div class="col_3">
			<img src="<?php echo $baseUrl;?>/images/default_avatar.jpg"  width="100%" height="100%" />
		</div>
		<div class="col_3">
			<img src="<?php echo $baseUrl;?>/images/default_avatar.jpg"  width="100%" height="100%" />
		</div>
		<div class="col_3">
			<img src="<?php echo $baseUrl;?>/images/default_avatar.jpg"  width="100%" height="100%" />
			<span id="jushou" style="position:relative; bottom:80px; left:30px;">夏小强举手了 <button onclick="$('#courseimage').attr('src','<?php echo $baseUrl;?>/images/default_avatar.jpg'); $('#jushou').fadeOut();">同意发言</button></span>
		</div>
		<div class="col_3">
			<img src="<?php echo $baseUrl;?>/images/default_avatar.jpg"  width="100%" height="100%" />
		</div>
		<div class="col_3">
			<img src="<?php echo $baseUrl;?>/images/default_avatar.jpg"  width="100%" height="100%" />
		</div>
		<div class="col_3">
			<img src="<?php echo $baseUrl;?>/images/default_avatar.jpg"  width="100%" height="100%" />
		</div>
		<div class="col_3">
			<img src="<?php echo $baseUrl;?>/images/default_avatar.jpg"  width="100%" height="100%" />
		</div>
		<div class="col_3">
			<img src="<?php echo $baseUrl;?>/images/default_avatar.jpg"  width="100%" height="100%" />
		</div>
		<div class="col_3">
			<img src="<?php echo $baseUrl;?>/images/default_avatar.jpg"  width="100%" height="100%" />
		</div>
	</div>
	<div class="col_4">
		<div><embed src="http://cdllyl.st.chatango.com/mini" bgcolor="#FFFFFF" width=300 height=350 wmode="transparent"  type=application/x-shockwave-flash  allowScriptAccess='always' allowNetworking='all' allowFullScreen='true'  flashvars="k=1&f=16"/><br><a href="http://chatango.com/signupmini"><img src="http://st.chatango.com/images/t.gif" border=0></a></div>	</div>
</div>


<script type="text/javascript">
	$(document).ready(function(){
		$('#painter').wPaint({
		    mode                : 'Pencil',         // drawing mode - Rectangle, Ellipse, Line, Pencil, Eraser
		    lineWidthMin        : '0',              // line width min for select drop down
		    lineWidthMax        : '10',             // line widh max for select drop down
		    lineWidth           : '2',              // starting line width
		    fillStyle           : '#FFFFFF',        // starting fill style
		    strokeStyle         : '#FFFF00',        // start stroke style
		    fontSizeMin         : '8',              // min font size in px
		    fontSizeMax         : '20',             // max font size in px
		    fontSize            : '12',             // current font size for text input
		    fontFamilyOptions   : ['Arial', 'Courier', 'Times', 'Trebuchet', 'Verdana'],
		    fontFamily          : 'Arial',          // active font family for text input
		    fontTypeBold        : false,            // text input bold enable/disable
		    fontTypeItalic      : false,            // text input italic enable/disable
		    fontTypeUnderline   : false,            // text input italic enable/disable
		    image               : null,             // preload image - base64 encoded data
		    drawDown            : null,             // function to call when start a draw
		    drawMove            : null,             // function to call during a draw
		    drawUp              : null,             // function to call at end of draw
		    menu                : ['undo','clear','rectangle','ellipse','line','pencil','text','eraser','fillColor','lineWidth','strokeColor'] // menu items - appear in order they are set
		});
		$( "._wPaint_menu" ).hide();
	});
</script>