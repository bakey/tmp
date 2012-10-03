<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>


<div class="page-header">
  <h1><?php echo $cschool->name; ?> <small> 欢迎 行政人员:<?php echo Yii::app()->user->real_name; ?></small></h1>
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
  <li class="span3">
    <div class="thumbnail linkthumbnail">
      <a href="<?php echo Yii::app()->createUrl('/user/libuser/home'); ?>"><div class="caption">
        <h3>课程管理</h3>
        <p>blah blah blah blah blah blah blah blah blah....</p>
      </div></a>
    </div>
  </li>
  <li class="span3">
    <div class="thumbnail linkthumbnail">
      <a href="<?php echo Yii::app()->createUrl('/user/libuser/teacheradmin'); ?>"><div class="caption">
        <h3>教师管理</h3>
        <p>blah blah blah blah blah blah blah blah blah....</p>
      </div></a>
    </div>
  </li>
  <li class="span3">
    <div class="thumbnail linkthumbnail">
      <a href="<?php echo Yii::app()->createUrl('/user/libuser/home'); ?>"><div class="caption">
        <h3>学生管理</h3>
        <p>blah blah blah blah blah blah blah blah blah....</p>
      </div></a>
    </div>
  </li>
  <li class="span3">
    <div class="thumbnail linkthumbnail">
      <a href="<?php echo Yii::app()->createUrl('/user/libuser/home'); ?>"><div class="caption">
        <h3>班级管理</h3>
        <p>blah blah blah blah blah blah blah blah blah....</p>
      </div></a>
    </div>
  </li>
</ul>