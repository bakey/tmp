<?php
/* @var $this ProfileController */
/* @var $model Profile */
$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();
$cs->scriptMap=array(
        'jquery.js'=>false,
);
$cs->registerScriptFile($baseUrl.'/js/jquery.jeditable.mini.js');

?>

<?php /*$this->widget('bootstrap.widgets.TbButtonGroup', array(
    'buttons'=>array(
        array('label'=>'编辑', 'url'=>Yii::app()->createUrl('/user/profile/update',array('id'=>$model->uid))),
        array('label'=>'修改密码', 'url'=>Yii::app()->createUrl('/user/libuser/changepassword',array('id'=>$model->uid))),
    ),
)); */
?>			
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
							'htmlOptions'=>array('class'=>'nullclass bordered'),
							'attributes'=>array(
								array(
									'label'=>'用户头像',
									'type'=>'raw',
									'value'=>'<a href="javascript:void(0)" class="libtooltip" title="点击修改头像！" onclick="dochangeavatar()">'.$avatarCode.'</a>',
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
								array(
									'name'=>'user_info.mobile',
									'template'=>'<tr><th>{label}</th><td><a class="libtooltip" title="点击就可以修改！" href="javascript:void(0);" id="mobileeditable">{value}</a></td></tr>',
								),
								array(
									'name'=>'user_info.user_profile.description',
									'template'=>'<tr><th>{label}</th><td><a class="libtooltip" title="点击就可以修改！" href="javascript:void(0);" id="jjeditable">{value}</a></td></tr>',
								),
							),
					)); ?>
				</div>
				<div class="container">
					<div class="content">
						<button class="turkish col_7 offset_3 omega" onclick="$.fn.modal({url: '<?php echo Yii::app()->createUrl('/user/libuser/changepassword',array('id'=>Yii::app()->user->id)) ?>',
   content: '<div class=\'libajaxloader\'></div>'})"><span>修改密码</span></button>
					</div>
				</div>
			</div>
    </div>

    <script type="text/javascript">

    	function dochangeavatar(){
    		$.fn.modal({url: '<?php echo Yii::app()->createUrl('/user/profile/update',array('id'=>Yii::app()->user->id)) ?>',
   content: '<div class="libajaxloader"></div>'});
    	}
    	$(document).ready(function(){
    		$(".libtooltip").tooltip({edgeOffset:         30,
    defaultPosition:    "right",});
    		$('#mobileeditable').editable('<?php echo Yii::app()->createUrl("/user/libuser/updatemobilephone",array("id"=>Yii::app()->user->id,"clicktoedit"=>1)); ?>', {
		         indicator : '<?php echo CHtml::image(Yii::app()->request->baseUrl."/images/ajax-loader.gif","alt",array()); ?>',
		         tooltip   : 'Click to edit...',
		         onblur    : 'submit',
		         submit    : '修改',
		         cssclass  : 'jetext',
 		     });
    		$('#jjeditable').editable('<?php echo Yii::app()->createUrl("/user/profile/update",array("id"=>Yii::app()->user->id,"clicktoedit"=>1)); ?>', {
		         indicator : '<?php echo CHtml::image(Yii::app()->request->baseUrl."/images/ajax-loader.gif","alt",array()); ?>',
		         tooltip   : 'Click to edit...',
		         type      : 'textarea',
		         onblur    : 'submit',
		         submit    : '修改',
		     });
    	});
    </script>