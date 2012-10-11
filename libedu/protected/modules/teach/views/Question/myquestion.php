<?php
/* @var $this QuestionController */
/* @var $dataProvider CActiveDataProvider */

/*$this->menu=array(
	array('label'=>'Create Question', 'url'=>array('create')),
	array('label'=>'Manage Question', 'url'=>array('admin')),
);*/
?>

<h3><?php
	if(Yii::app()->user->urole == 1){
		echo '最近的问答';
	}else if(Yii::app()->user->urole == 2){
		echo '未回答的问题';
	}
	Yii::app()->getClientScript()->scriptMap=array(
		'jquery.js'=>false,
);
?></h3>

<?php 
$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
<h3>我的问答</h3>
<div class="row-fluid">
	<div class="span3 well">
		<h5>选择章节</h5>
		<?php
		/* @var $this UserController */
		/* @var $data User */
			$url = 'question/ajaxFillTree&edition_id='.$eid;
				$this->widget(
					    'CTreeView',
						array(
				            'animated'=>'fast', //quick animation
				            'collapsed' => false,
				            'url' => array( $url ),
						)
				);
		?>


	</div>
	<script type="text/javascript">
	function doselectchapter(cid){
		 $.ajax({
		  	url:'<?php echo Yii::app()->createUrl("/teach/question/getquestionbyitem"); ?>',
		  	type:'POST',
		  	data:{uid:<?php echo Yii::app()->user->id; ?>,chid:cid},
		  	success:function(response){
		  		$('#questiongroupbyitem').html(response);
		  	},
		 });
	}
</script>
	<div class="span9 well" id="questiongroupbyitem">
		&nbsp;
	</div>
</div>


