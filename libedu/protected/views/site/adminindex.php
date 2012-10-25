<?php
$this->pageTitle=Yii::app()->name;
Yii::app()->getClientScript()->scriptMap=array(
		'jquery.js'=>false,
);
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
	}

	if(targettabindex == 1){
		$('#recentquestions').hide().html(' ');
	}

}
</script>

<div class="container" style="margin-top:50px">

  <h2 style="text-align:center; margin-bottom:0; font-size:34px;">我的课程</h2>

<div class="carton col_12 nobackground">

<div class="container dotbottom normaltoppadding">
            <a href="javascript:void(0);" onclick="changeToTabByIndex(event,0)" rel="external">
            <div class="carton col_2" style="margin-right:0 !important; margin-left:30%;">
              <div class="subcontent homepagesubcontent bordered sail" >管
              </div>
            </div></a>

            <a href="javascript:void(0);" onclick="changeToTabByIndex(event,1)" rel="external">
            	<div class="carton col_2"  style="margin-left:-1px !important;" >
              <div class="subcontent homepagesubcontent bordered">教
              </div>
            </div></a>
            
             <a href="javascript:void(0);" onclick="changeToTabByIndex(event,2)" rel="external">
             	<div class="carton col_2"  style="margin-left:-10px !important;" >
              <div class="subcontent homepagesubcontent bordered">学
              </div>
            </div></a>
</div>
        
        <a href="index.php?r=teach/edition/admin" onclick="" rel="external">
            <div class="carton col_3 coursecarton">
              <h2>行政管理</h2>
              <div class="content current courseitemcontent">
              	<p style="margin-top:20px !important;">
              		<span class>我的管理</span>
              	</p>
             </div>
            </div>
          </a>

          <a href="index.php?r=app/libstore" onclick="" rel="external">
            <div class="carton col_3 coursecarton">
              <h2>添加管理应用</h2>
              <div class="content current courseitemcontent"><p style="margin-top:20px !important;"><span class="iconclass min">+</span></p></div>
            </div>
          </a>
        </div>
</div>



</div>

<script type="text/javascript">
  $('#header .con li.siteindex').addClass('dashboard');
</script>
