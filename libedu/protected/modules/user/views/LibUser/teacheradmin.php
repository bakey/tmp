<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
    'links'=>array('系统管理'=>'#', '教师管理'),
)); ?>

<div class="page-header">
  <h2>系统管理 <small>教师管理</small></h2>
</div>


<h4>最近加入的教师</h4>
<?php
 $this->widget( 'bootstrap.widgets.TbGridView' , array(
 			'type'=>'striped bordered condensed',
   			'dataProvider'=>$nocourseProvider,
   			'columns'=>array(
   				array(
   					'name'=>'id',
   				),
   				array(
   					'name'=>'姓名',
   					'value'=>'$data->user_profile->real_name',
   				),
   				array(
   					'name'=>'email'
   				),
   				array(
				   	'class'=>'CLinkColumn',
				    'header'=>'操作',
				    'labelExpression'=>'"关联课程"',
				    'urlExpression'=>'"'.Yii::app()->createUrl('/user/profile/update').'&id=".$data->id',
   				),
   			),
 		));
?>

<hr />

<h4>已邀请但未加入的教师</h4>
<?php
 $this->widget( 'bootstrap.widgets.TbGridView' , array(
 			'type'=>'striped bordered condensed',
   			'dataProvider'=>$nojoinProvider,
   			'columns'=>array(
   				array(
   					'name'=>'姓名',
   					'value'=>'$data->name',
   				),
   				array(
   					'name'=>'邮箱',
   					'value'=>'$data->school_unique_id'
   				),
   				array(
				   	'class'=>'CLinkColumn',
				    'header'=>'操作',
				    'labelExpression'=>'"再次邀请"',
				    'urlExpression'=>'"'.Yii::app()->createUrl('/user/libuser/inviteteacheragain').'&uaid=".$data->school_unique_id',
   				),
   			),
 		));
?>

<hr />
<h4>已加入本校教师</h4>
<ul class="thumbnails">
	<?php 
		foreach($joined as $singlelec){
			$avatarCode = ''; 
if($singlelec->user_info->user_profile->avatar != 'default_avatar.jpg'){
	$avatarCode = html_entity_decode(CHtml::image(Yii::app()->request->baseUrl.'/'.Yii::app()->params['uploadFolder'].'/'.$singlelec->user_info->id.'/avatar/'.$singlelec->user_info->user_profile->avatar,'alt',array('width'=>64,'height'=>64,'style'=>'float:left;margin-right:10px;margin-bottom:10px;')));
}else{
	$avatarCode = html_entity_decode(CHtml::image(Yii::app()->request->baseUrl.'/images/'.$singlelec->user_info->user_profile->avatar,'alt',array('width'=>64,'height'=>64,'style'=>'float:left;margin-right:10px;margin-bottom:10px;')));
}
			echo '<li class="span4">
    <div class="thumbnail linkthumbnail">

      <a href="'.Yii::app()->createUrl('/user/profile/viewprofile',array('id'=>$singlelec->user_id)).'"><div class="caption">'.$avatarCode.'
        <h4>'.$singlelec->user_info->user_profile->real_name.'</h4>
        <p>'.$singlelec->user_info->email.'</p>
      </div></a>
    </div>
  </li>';
		}
	?>
</ul>
