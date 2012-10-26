<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
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

	}

	function addcourse(){
	  $.fn.modal({
	    'url':'<?php echo Yii::app()->createUrl("teach/course/createpersonalcourse"); ?>',
	    'padding':'20px',
	    'height': 650,
	  });
	}
</script>

<div class="container" style="margin-top:50px">

  <h2 style="text-align:center; margin-bottom:0; font-size:34px;">我的课程</h2>

<div class="carton col_12 nobackground">

<div class="container dotbottom normaltoppadding">
            <a href="javascript:void(0);" onclick="changeToTabByIndex(event,0)" rel="external"><div class="carton col_2" style="margin-right:0 !important; margin-left:36%;">
              <div class="subcontent homepagesubcontent bordered sail" >
                学
              </div>
            </div></a>

            <a href="javascript:void(0);" onclick="changeToTabByIndex(event,1)" rel="external"><div class="carton col_2"  style="margin-left:-1px !important;" >
              <div class="subcontent homepagesubcontent bordered">
                教
              </div>
            </div></a>
          </div>

        <div class="content animated fadeInLeft tinyallpadding" id="recentquestions" style="min-height:200px;">
          <?php 
            foreach($courselist as $singlecourse){
              echo '<a href="'.Yii::app()->createUrl('/teach/course/update',array('course_id'=>$singlecourse->id)).'" rel="external">
            <div class="carton col_3 coursecarton">
              <h2>'.$singlecourse->name.'</h2>
              <div class="content current courseitemcontent"><p><b>创建日期</b></p><p>2012-09-01</p><p><b>任教班级</b></p><p>高一 (1) 班, 高一 (2) 班</p></div>
            </div></a>';
            }
          ?> 

          <a href="javascript:void(0)" onclick="addcourse()" rel="external">
            <div class="carton col_3 coursecarton">
              <h2>添加课程</h2>
              <div class="content current courseitemcontent"><p style="margin-top:20px !important;"><span class="iconclass min">+</span></p></div>
            </div></a>
        </div>
        <div class="content animated fadeInLeft tinytinyallpadding">
          您暂没有教学的班级
        </div>
</div>



</div>

<script type="text/javascript">
  $('#header .con li.siteindex').addClass('dashboard');
</script>