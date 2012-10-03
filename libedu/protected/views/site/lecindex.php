<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>


<div class="page-header">
  <h1><?php echo $cschool->name; ?> <small> 欢迎 <?php echo Yii::app()->user->real_name; ?>老师</small></h1>
</div>

<ul class="thumbnails">
  <li class="span3">
    <div class="thumbnail linkthumbnail">
      <a href="<?php echo Yii::app()->createUrl('/user/libuser/home'); ?>"><div class="caption">
        <h3>个人中心</h3>
        <p>个人中心的介绍 blah blah blah blah blah blah blah blah blah....</p>
      </div></a>
    </div>
  </li>
</ul>

<hr class="darkhr" />


<ul class="thumbnails">
<?php 
	foreach($courselist as $singlecourse){
		echo '<li class="span3">
    <div class="thumbnail linkthumbnail">
      <a href="'.Yii::app()->createUrl('/teach/course/update',array('course_id'=>$singlecourse->id)).'"><div class="caption">
        <h3>'.$singlecourse->name.'</h3>
        <p>'.$singlecourse->description.'</p>
      </div></a>
    </div>
  </li>';
	}
?> 
</ul>