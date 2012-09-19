<h4><?php if(isset($classname)) echo $classname; ?>学生情况表</h4>
<?php 
if(isset($notclasshead)){
	echo '<h4>您不是班主任</h4>';
}else{
	$this->widget('zii.widgets.grid.CGridView',
		array(
			'id'=>'uploadedStu',
			'dataProvider'=>$dataProvider,
			'columns'=>array(
					array(
						'name' => '学号'
					),
					array(
						'name' => '姓名'
					),
					array(
						'name' => '状态'
					),
					 
			),
		)
	);
}
?>