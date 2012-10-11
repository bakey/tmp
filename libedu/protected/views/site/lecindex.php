<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;

Yii::app()->getClientScript()->scriptMap=array(
		'jquery.js'=>false,
);
?>

<div class="container">
  <a href="#" rel="external">
  <div class="carton col_4">
    <h2>个人中心</h2>
    <div class="content"><p>个人中心的介绍 可以搞一张图什么的 blah blah blah blah blah blah blah blah blah....</p></div>
  </div></a>
</div>
<p class="offset_6">横向时间轴占位</p>
<hr />
<p class="offset_6">横向时间轴占位</p>

<div class="container">
<?php 
	foreach($courselist as $singlecourse){
		echo '<a href="'.Yii::app()->createUrl('/teach/course/update',array('course_id'=>$singlecourse->id)).'" rel="external">
  <div class="carton col_3 coursecarton">
    <h2>'.$singlecourse->name.'</h2>
    <div class="content"><p>'.$singlecourse->description.'</p></div>
  </div></a>';
	}
?> 

<a href="#" rel="external">
  <div class="carton col_3 coursecarton">
    <h2>添加课程</h2>
    <div class="content"><p><span class="iconclass min offset_5">+</span></p></div>
  </div></a>

</div>

<script type="text/javascript">
  $('#header .con li.siteindex').addClass('dashboard');
</script>
