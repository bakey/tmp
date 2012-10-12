 <div id="tab_one" class="tab mytab current">
 	<div class="carton col_4 topitemcarton post_title" >
 		<div class="content">
    <?php
    	if ( $post_model != null ) 
		{
 			echo $post_model->id . ": " . $post_model->title ;
		} 
 	?>
  		</div>
	</div>
<div class="carton post_grid">
<?php 
	if ( $post_model != null )
	{
		echo $post_model->post;
	}
?>
</div>
</div>
<?php 
/*
$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'post:html',
		array(
			'name'  => 'status',
			'value' => $model->status == CoursePost::STATUS_DRAFT ? "草稿" : "已发布",
		),
	),
));*/
/*
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
*/
?>

