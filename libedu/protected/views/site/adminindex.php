<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;

Yii::app()->getClientScript()->scriptMap=array(
		'jquery.js'=>false,
);
?>



<div class="page-header">
  <h1><?php echo $cschool->name; ?> <small> 欢迎 行政人员:<?php echo Yii::app()->user->real_name; ?></small></h1>
</div>

<ul class="thumbnails">
  <li class="carton span3">
    <div class="thumbnail linkthumbnail">
      <a href="<?php echo Yii::app()->createUrl('/user/libuser/home'); ?>">
      <div class="caption">
        <h3>个人中心</h3>
        <p>个人中心的介绍 blah blah blah blah blah blah blah blah blah....</p>
      </div>
      </a>
    </div>
  </li>
</ul>

<hr class="darkhr" />


<a href="index.php?r=teach/edition/admin" rel="external">
  <div class="carton col_3 coursecarton">
    <h2>行政管理</h2>
    <div class="content">
    	<p>行政管理</p>
    </div>
  </div>
</a>
  <a href="#" rel="external">
  <div class="carton col_3 coursecarton">
    <h2>添加应用</h2>
    <div class="content"><p><span class="iconclass min offset_5">+</span></p></div>
  </div></a>
  