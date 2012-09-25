<?php
/* @var $this SiteController */

	$this->pageTitle=Yii::app()->name;
	$baseUrl = Yii::app()->baseUrl; 
	$cs = Yii::app()->getClientScript();
	Yii::app()->clientScript->registerCoreScript('jquery');
	$cs->registerScriptFile($baseUrl.'/js/jquery.masonry.min.js');
	$cs->registerScriptFile($baseUrl.'/js/jquery.masonry.ordered.js');
	$cs->registerCssFile($baseUrl.'/css/cc_timeline.css');
?>

<h1>Timeline Test</h1>
<div id="timeline_line">
<div id="timeline_item_container">
	<div class="timeline_item">
		<p>Ut condimentum mi vel tellus. Suspendisse laoreet. Fusce ut est sed dolor gravida convallis. Morbi vitae ante. Vivamus ultrices luctus nunc. Suspendisse et dolor. Etiam dignissim. Proin malesuada adipiscing lacus. Donec metus. Curabitur gravida1.</p>
	</div>
	<div class="timeline_item">
		<p>Ut condimentum mi vel tellus. Suspendisse laoreet. Fusce ut est sed dolor gravida convallis. Morbi vitae ante. Vivamus ultrices luctus nunc2.</p>
	</div>	
	<div class="timeline_item">
		<p>Morbi purus libero, faucibus adipiscing, commodo quis, gravida id, est. Sed lectus. Praesent elementum hendrerit tortor. Sed semper lorem at felis.</p>

		<p>Sed ac risus. Phasellus lacinia, magna a ullamcorper laoreet, lectus arcu pulvinar risus, vitae facilisis libero dolor a purus. Sed vel lacus. Mauris nibh felis, adipiscing varius, adipiscing in, lacinia vel, tellus. Suspendisse ac urna. Etiam pellentesque mauris ut lectus. Nunc tellus ante, mattis eget, gravida vitae, ultricies ac, leo. Integer leo pede, ornare a, lacinia eu, vulputate vel, nisl.</p>

		<p>Sed ac risus. Phasellus lacinia, magna a ullamcorper laoreet, lectus arcu pulvinar risus, vitae facilisis libero dolor a purus. Sed vel lacus. Mauris nibh felis, adipiscing varius, adipiscing in, lacinia vel, tellus. Suspendisse ac urna. Etiam pellentesque mauris ut lectus. Nunc tellus ante, mattis eget, gravida vitae, ultricies ac, leo. Integer leo pede, ornare a, lacinia eu, vulputate vel, nisl.3</p>
	</div>
	<div class="timeline_item">
		<p>Sed ac risus. Phasellus lacinia, magna a ullamcorper laoreet, lectus arcu pulvinar risus, vitae facilisis libero dolor a purus. Sed vel lacus. Mauris nibh felis, adipiscing varius, adipiscing in, lacinia vel, tellus. Suspendisse ac urna. Etiam pellentesque mauris ut lectus. Nunc tellus ante, mattis eget, gravida vitae, ultricies ac, leo. Integer leo pede, ornare a, lacinia eu, vulputate vel, nisl.4</p>
	</div>
	<div class="timeline_item">
		<p>Morbi purus libero, faucibus adipiscing, commodo quis, gravida id, est. Sed lectus. Praesent elementum hendrerit tortor. Sed semper lorem at felis.5</p>
	</div>
	<div class="timeline_item">
		<p>Sed ac risus. Phasellus lacinia, magna a ullamcorper laoreet, lectus arcu pulvinar risus, vitae facilisis libero dolor a purus. Sed vel lacus. Mauris nibh felis, adipiscing varius, adipiscing in, lacinia vel, tellus. Suspendisse ac urna. Etiam pellentesque mauris ut lectus. Nunc tellus ante, mattis eget, gravida vitae, ultricies ac, leo. Integer leo pede, ornare a, lacinia eu, vulputate vel, nisl.6</p>
	</div>
	<div class="timeline_item">
		<p>Sed ac risus. Phasellus lacinia, magna a ullamcorper laoreet, lectus arcu pulvinar risus, vitae facilisis libero dolor a purus. Sed vel lacus. Mauris nibh felis, adipiscing varius, adipiscing in, lacinia vel, tellus. Suspendisse ac urna. Etiam pellentesque mauris ut lectus. Nunc tellus ante, mattis eget, gravida vitae, ultricies ac, leo. Integer leo pede, ornare a, lacinia eu, vulputate vel, nisl.</p>

		<p>Sed ac risus. Phasellus lacinia, magna a ullamcorper laoreet, lectus arcu pulvinar risus, vitae facilisis libero dolor a purus. Sed vel lacus. Mauris nibh felis, adipiscing varius, adipiscing in, lacinia vel, tellus. Suspendisse ac urna. Etiam pellentesque mauris ut lectus. Nunc tellus ante, mattis eget, gravida vitae, ultricies ac, leo. Integer leo pede, ornare a, lacinia eu, vulputate vel, nisl.7</p>
	</div>
	<div class="timeline_item">
		<p>Sed ac risus. Phasellus lacinia, magna a ullamcorper laoreet, lectus arcu pulvinar risus, vitae facilisis libero dolor a purus. Sed vel lacus. Mauris nibh felis, adipiscing varius, adipiscing in, lacinia vel, tellus8.</p>
	</div>
</div>
</div>

<script type="text/javascript">
	$(function(){
	  $('#timeline_item_container').masonry({
	    // options
	    itemSelector : '.timeline_item',
	    columnWidth : 360,
	    isAnimated: true,
	    layoutPriorities: {
	    	shelfOrder:1,
	    },
	  });
	  Arrow_Points();
	});

	function Arrow_Points(){ 
		var s = $('#timeline_item_container').find('.timeline_item');
		var ttl = 0;
		var previousPos = 0;
		var previousLeftBottom = 0;
		var previousRightBottom = 0;
		var previousDirection = 0;
		var currentDirection = 0;
		$.each(s,function(i,obj){
			var posLeft = $(obj).css("left");
			if(posLeft == "0px")
			{
				ttl++;
				$(obj).addClass('leftArrow');
				html = "<span class='rightCorner timeline_corner'></span>";
				$(obj).prepend(html); 
				$(obj).find('.timeline_corner').css('margin-top',Math.round(($(obj).height())*0.38)-24+'px');
				currentDirection = 0;
			}else{
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
				finalpos=10;
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
			}
		});
	}
</script>