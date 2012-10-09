<?php
/* @var $this ProfileController */
/* @var $model Profile */

?>

<?php /*$this->widget('bootstrap.widgets.TbButtonGroup', array(
    'buttons'=>array(
        array('label'=>'编辑', 'url'=>Yii::app()->createUrl('/user/profile/update',array('id'=>$model->uid))),
        array('label'=>'修改密码', 'url'=>Yii::app()->createUrl('/user/libuser/changepassword',array('id'=>$model->uid))),
    ),
)); */
?>

<ul class="tabs">
    <li class="current">
        <a href="#tab_one">我的账号</a>
    </li>
    <li>
        <a href="#tab_two">账号管理</a>
    </li>
</ul>
<div class="tabs">
    <div id="tab_one" class="tab">
    	<div class="container">
    		<div class="carton col_12">
				<h2><?php echo $model->real_name; ?>的账号</h2>
				<div class="content">
					<?php
						$avatarCode = ''; 
						if($model->avatar != 'default_avatar.jpg'){
							$avatarCode = html_entity_decode(CHtml::image(Yii::app()->request->baseUrl.'/'.Yii::app()->params['uploadFolder'].'/'.$model->user_info->id.'/avatar/'.$model->avatar,'alt',array('width'=>64,'height'=>64)));
						}else{
							$avatarCode = html_entity_decode(CHtml::image(Yii::app()->request->baseUrl.'/images/'.$model->avatar,'alt',array('width'=>64,'height'=>64)));
						}

						$coursestring = '';
						foreach($usc as $singlecls){
							$coursestring.=' '.$singlecls->name;
						}

						$clsstring = '';
						foreach($ucls as $singlecls){
							$clsstring.=' '.$singlecls->name;
						}

						$this->widget('zii.widgets.CDetailView', array(
							'data'=>$model,
							'itemCssClass'=>'',
							'htmlOptions'=>array('class'=>'nullclass'),
							'attributes'=>array(
								array(
									'label'=>'用户头像',
									'type'=>'raw',
									'value'=>$avatarCode,
								),
								'real_name',
								array(
									'label'=>'课程',
									'value'=>$coursestring,
								),
								array(
									'label'=>'授课班级',
									'value'=>$clsstring,
								),
								'user_info.email',
								'user_info.mobile',
								'description',
							),
					)); ?>
				</div>
				<div class="container">
					<div class="content">
						<button class="turkish col_3 alpha"><span>编辑</span></button>
						<button class="turkish col_5 omega" onclick="$.fn.modal({
   content: '<div class=\'libajaxloader\'></div>'})"><span>修改密码</span></button>
					</div>
				</div>
			</div>
    </div>
</div>
<div id="tab_two" class="tab">Content of tab 1</div>
</div>