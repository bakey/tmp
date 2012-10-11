<?php
/* @var $this SiteController */

	$this->pageTitle=Yii::app()->name;
	$baseUrl = Yii::app()->baseUrl; 
	$cs = Yii::app()->getClientScript();
	$baseUrl = Yii::app()->baseUrl; 
		$cs = Yii::app()->getClientScript();
		$cs->scriptMap=array(
		        'jquery.js'=>false,
		);
	$cs->registerScriptFile($baseUrl.'/js/jquery.masonry.min.js');
	$cs->registerScriptFile($baseUrl.'/js/jquery.masonry.ordered.js');
	$cs->registerCssFile($baseUrl.'/css/cc_timeline.css');
?>

<h1>个人中心</h1>
<div id="timeline_line">
	<div id="timeline_navigator">
		<ul>
			<li>
				2012
				<ul>
					<li>一月</li>
					<li>二月</li>
					<li>三月</li>
					<li>四月</li>
					<li>五月</li>
					<li>六月</li>
					<li>七月</li>
					<li>八月</li>
					<li>九月</li>
					<li>十月</li>
					<li>十一月</li>
					<li>十二月</li>
				</ul>
			</li>
			<li>2011</li>
		</ul>
	</div>
	<div id="timeline_item_container">
		<h3>正在读取时间轴……</h3>
	</div>
	<div style="clear:both">&nbsp;</div>
</div>

<script type="text/javascript">
	$('#header .con li.userhome').addClass('dashboard');
	function Arrow_Points(nobj){
		var s = $(nobj).find('.timeline_item');
		var ttl = 0;
		var previousPos = 0;
		var previousLeftBottom = 0;
		var previousRightBottom = 0;
		var previousDirection = 0;
		var currentDirection = 0;
		$.each(s,function(i,obj){
			/*var posLeft = $(obj).css("left");
			if(posLeft == "0px")
			{*/

				ttl++;
				if($(obj).attr('rel')=='1st'){
					html = "<span class='leftCorner timeline_corner'></span>";
					$(obj).prepend(html); 
					$(obj).addClass('rightArrow');
					$(obj).find('.timeline_corner').css('margin-top',Math.round(($(obj).height())*0.38)-24+'px');
				}
				currentDirection = 0;
			/*}else{
				ttl++;
				html = "<span class='leftCorner timeline_corner'></span>";
				$(obj).prepend(html);
				$(obj).addClass('rightArrow');
				$(obj).find('.timeline_corner').css('margin-top',Math.round(($(obj).height())*0.38)-24+'px');
				currentDirection = 1;
			}
			var finalpos=0;
			if($(obj).find('.timeline_corner').offset().top>previousPos){
				previousPos = $(obj).find('.timeline_corner').offset().top;
			}else{
				finalpos=50;
				while($(obj).find('.timeline_corner').offset().top+finalpos<previousPos){
				   finalpos +=50;	
				}
			}
			if(currentDirection == 1){
				if($(obj).offset().top+finalpos<previousRightBottom){
					while($(obj).offset().top+finalpos<previousRightBottom){
						finalpos +=50;
					}
				}
			}else{
				if($(obj).offset().top+finalpos<previousLeftBottom){
					while($(obj).offset().top+finalpos+finalpos<previousLeftBottom){
						finalpos +=50;
					}	
				}
			}
			$(obj).css('margin-top',Math.round(finalpos)+10+'px');
			previousPos = $(obj).find('.timeline_corner').offset().top;
			previousDirection = currentDirection;
			if(currentDirection == 0){
				previousLeftBottom = $(obj).offset().top+$(obj).height();
			}else{
				previousRightBottom = $(obj).offset().top+$(obj).height();
			}*/
		});
	}

	$.ajax({
	  	url:'<?php echo Yii::app()->createUrl("/user/libuser/gettimeline",array("uid"=>Yii::app()->user->id)); ?>',
	  	success:function(response){
	  		$('#timeline_item_container').html(response + '</div>');
	  		var s = $('#timeline_item_container').find('.singleDayContainer');
	  		$.each(s,function(i,obj){
				$(obj).masonry({
				    // options
				    itemSelector : '.timeline_item',
				    columnWidth : 320,
				    isAnimated: true,
				    layoutPriorities: {
				    	shelfOrder:1,
				    },
				});
				$(obj).css('margin-top','60px');
				Arrow_Points(obj);	  		
	  		});
	  	},
	  });
</script>