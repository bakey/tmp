<h1>导入学生信息卡</h1>
<h4>学校：<?php echo $schoolname;?> （学校ID：<?php echo $schoolid; ?>）</h4>
<?php $this->widget('zii.widgets.CListView',
		array(
			'id'=>'uploadedStu',
			'dataProvider'=>$dataProvider,
			'itemView'=>'_stucard',
		)
	);
?>