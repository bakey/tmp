<h4>学校：<?php echo $schoolname;?> （学校ID：<?php echo $schoolid; ?>）</h4>

<?php $this->widget('zii.widgets.grid.CGridView',
		array(
			'id'=>'uploadedStu',
			'dataProvider'=>$dataProvider,
			'columns'=>array(
					array(
						'name' => '序号'
					),
					array(
						'name' => '姓名'
					),
					array(
						'name' => '邮箱'
					),
					/*array(
						'header'=>'备注',
						'name' => 'failreason',
					),*/
					 
			),
		)
	);
?>