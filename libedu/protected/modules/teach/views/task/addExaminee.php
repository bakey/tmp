<form method="post">
<h1><?php echo '为第'.$id.'次测试添加考生'; ?></h1>
<input type="hidden" name="taskid" value=<?php echo $id;?> />

<?php echo CHtml::label('学号',false); ?>
<?php for($i=0;$i<15;$i++)
echo '&nbsp';
?>
<?php echo CHtml::label('班级',false); ?>
<?php for($i=0;$i<15;$i++)
echo '&nbsp';
?>
<?php echo CHtml::label('选择',false); ?><br><br>
<?php 
for($j=0;$j<count($data);$j++)
{
    echo $data[$j]->student_id;
	for($i=0;$i<18;$i++)
		echo '&nbsp';
	echo $data[$j]->class_id;
    for($i=0;$i<18;$i++)
		echo '&nbsp';
	echo CHtml::checkBox("sel[]",null,array('value'=>$data[$j]->student_id));
	echo '<br>';
}
?> 
<br>
<?php echo CHtml::label('添加此次测试的内容描述',false); ?><br><br>
<textarea name="content" rows="10" cols="30"></textarea>
<br><br>
<?php echo CHtml::Button('发布测试',array(
			'submit'=>array('task/examinee','taskid'=>$id),
			'params'=>array('command'=>'examinee','taskid'=>$id),
			'confirm'=>'你确定为此次测试添加考生吗?'));  
?>
</form>