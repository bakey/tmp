<?php
Yii::app()->getClientScript()->scriptMap=array(
'jquery.js'=>false,
);
?>
<h1>
<?php
	echo(Yii::app()->user->real_name . ",");
	echo("这是你的课程: " ); 
?>
</h1>
<?php
foreach ( $course_data as $course )
{?> 
<a href="<?php echo ("index.php?r=teach/course/update&course_id=" . $course->id );?>" rel="external">
	<button class="sea glyph tag" >
		<?php echo $course->name; ?>
	</button>
</a>
<?php 
}
?>
<?php
//$this->renderPartial( '_form_admin_course' , array('dataProvider'=>$dataProvider)); 
?>
