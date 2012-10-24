<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>


<div class="page-header">
  <h1><?php echo $cschool->name; ?> <small> 欢迎 <?php echo Yii::app()->user->real_name; ?>同学</small></h1>
</div>

<div class="container">
  <a href="#" rel="external">
  <div class="carton col_4">
    <h2>个人中心</h2>
    <div class="content"><p><?php echo LibUser::model()->findByPk(Yii::app()->user->id)->user_profile->description; ?></p></div>
  </div></a>
</div>


<hr class="darkhr" />


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