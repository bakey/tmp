

<h1><?php echo $model->id . ": " . $model->title ; ?></h1>

<?php 

$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'post:html',
		array(
			'name'  => 'status',
			'value' => $model->status == CoursePost::STATUS_DRAFT ? "草稿" : "已发布",
		),
		//'status',
	),
));
echo CHtml::button('重新编辑' , array(
		'onClick'=>"window.location.href='$reedit_url'",
) );
echo CHtml::button('删除资料' , array('onClick'=>'if ( confirm("是否确认删除") ) { 
				window.location.href="index.php?r=teach/coursepost/delete&post_id='.$model->id .'&item_id='.$item_id.'"} ') );
if ( $model->status == Yii::app()->params['course_post_status_draft'] ) {
	echo CHtml::button('发布课程资料', array( 
		'onClick'=>"window.location.href='$draft_to_publish_url'", 
	));
}
?>
