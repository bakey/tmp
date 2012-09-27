
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'add-form',
	'enableAjaxValidation'=>true,
)); ?>

<style type="text/css">
p.two
{
position:absolute;
top:150px;
right:250px;
}
</style>

<p class="two">
您的试卷里共有:<br><br>
<?php 
$choice=0;
$blank=0;
$qa=0;
for($i=0;$i<count($data);$i++)
{
	if($data[$i]->type==0 || $data[$i]->type==1)
		$choice++;		
	else if($data[$i]->type==2)
		$blank++;
	else if($data[$i]->type==3)
		$qa++;
}
echo $choice.'道选择题;'. $blank.'道填空题;'. $qa.'道问答题';
?>

</p>


<form method="post">
<html>
<head><?php echo '为第'.$id.'次添加题目'; ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<?php header("content-type: text/html;charset=utf-8"); ?>
   <?php echo '<br><br>'; ?>
    <?php echo CHtml::label('题型',false); ?>
	<?php echo CHtml::dropDownList('typeid','',array(''=>'请选择题型:',0=>'单项选择',1=>'多项选择',2=>'填空题',3=>'问答题'),
		array(
			'ajax'=>array(
				'type'=>'POST',
				'url'=>array('topics'),//array('add','type'=>'js:this.value'),
				'update'=>'#param_id',
			//	'data'=>array('type'=>'js.this.value'),
				),
				)
	); ?>  
	
	
    <?php echo CHtml::label('难度',false); ?>
	<?php echo CHtml::dropDownList('levelid','',array(''=>'请选择难度:',0=>'简单',1=>'相对简单',2=>'中等难度',3=>'难',4=>'非常难'),
		array(
			'ajax'=>array(
				'type'=>'POST',
				'url'=>array('topics'),
				//'data'=>array('level'=>'js.this.value'),
				'update'=>'#param_id',),
				)
		);?>
   
	<br><br>
    
	<?php echo CHtml::radioButtonList('sortid','0',
		array(0=>'按照入库时间排序',1=>'按照使用次数排序'),
		array('separator'=>'',
			'onChange'=>CHtml::ajax(
					array('type'=>'POST','url'=>array('topics'),'update'=>'#param_id',)
					)));
	?>

    
	<hr width=150 style="border:1px dashed red; height:1px">
   
    <div id="param_id"><?php $this->renderPartial('topics',array('data'=>$data)); ?></div>
     <?php echo CHtml::Button('创建测试',array(
			'submit'=>array('task/createTaskProblem'),
			'params'=>array('command'=>'createTaskProblem','taskid'=>$id),
			'confirm'=>'你确定创建本次测试吗?'));  
	?>
</form>	  
    <?php $this->endWidget();?>
</html>