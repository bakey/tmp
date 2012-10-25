<?php
/* @var $this QuestionController */
/* @var $data Question */
?>

<div class="container">
	<div class="col_12 dotbottom topansweritem">
		<div class="carton col_11 tinyallpadding roundbordered normalbottommargin" id="topanswer<?php echo $data->id; ?>">
			<script type="text/javascript">
				$.ajax({
				  	url:'<?php echo Yii::app()->createUrl("/teach/question/getallmysubelement"); ?>',
				  	type:'GET',
				  	data:{qid:<?php echo $data->id; ?>,type:2},
				  	success:function(response){
				  		$('#topanswer'+<?php echo $data->id; ?>).html(response).hide().fadeIn();
				  	},
				 });
			</script>
			<div class="libajaxloader"></div>
		</div>
		<div class="carton col_9 offset_3 roundbordered tinyallpadding" style="margin-bottom:35px;">  
			<div class="container nobottommargin  questionop">
				<div class="col_12 dotbottom">
						<?php echo $data->details;?>
					
				</div>
				
				<div class="col_5">
					<p><?php echo CHtml::encode($data->owner_info->user_profile->real_name); ?> 提问于 <?php echo CHtml::encode($data->create_time); ?></p>	
				</div>
				<div class="col_1 offset_3">
					<p>收藏</p>
				</div>
				<div class="col_2">
					<p> <?php
				echo CHtml::link('追问'.'('.$data->numberofzw.')','javascript:void(0);',
					array(
					'onclick'=>CHtml::ajax( array('url'=>Yii::app()->createUrl('/teach/question/getallsubelement',array('qid'=>$data->id,'type'=>1)),
					'update'=>'#answer'.$data->id,'success'=>'js:function(data){$("#answer'.$data->id.'").html(data);$("#answer'.$data->id.'").fadeIn();}'
)),'id'=>'zwtrigger'.$data->id,

					));?></p>
				</div>
				<div class="col_2">
					<p> <?php
			echo CHtml::link('回答'.'('.$data->numberofanswers.')','javascript:void(0);',
					array(
					'onclick'=>CHtml::ajax( array('url'=>Yii::app()->createUrl('/teach/question/getallsubelement',array('qid'=>$data->id,'type'=>2)),
					'update'=>'#answer'.$data->id,'success'=>'js:function(data){$("#answer'.$data->id.'").html(data);$("#answer'.$data->id.'").fadeIn();}'
)),'id'=>'answertrigger'.$data->id,

					));
			?></p>
				</div>
			</div>
			<div class="carton roundbordered nobackground tinyallpadding" id="answer<?php echo $data->id ?>" style="display:none;">
			</div>
		</div>
	</div>
	
</div>