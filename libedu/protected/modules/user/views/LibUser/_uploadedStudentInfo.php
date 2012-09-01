<?php $this->widget('zii.widgets.grid.CGridView',
		array(
			'id'=>'uploadedStu',
			'dataProvider'=>$dataProvider,
			'columns'=>array(
					array(
						'name' => '序号'
					),
					array(
						'name' => '学号'
					),
					array(
						'name' => '姓名'
					),
					array(
						'name' => '年级'
					),
					array(
						'name' => '班级ID'
					),
					array(
						'name' => '班级'
					),
					 
			),
		)
	);
?>