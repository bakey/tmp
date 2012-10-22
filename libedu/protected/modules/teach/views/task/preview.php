<?php
Yii::app()->getClientScript()->scriptMap=array(
'jquery.js'=>false,
);
?>
<h4>本次测试的题目</h4>
<?php
 $this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$problem_data,
		'columns'=>array(
				array(
						'name'=>'题目id',
						'value' => '$data["id"]',
						'type'=>'raw',
				),
				array(
						//'name'=>'content',
						'name'=>'题目内容',
						'value' => '$data["content"]',
						'type'=>'html',
				),
				array(
						'name'=>'题目难度',
						'value' => '$data["difficulty"]',
						'type'=>'raw',
				),
				array(
						'name' => '题目类型',
						'value' => '$data["type"]',
						'type' => 'raw',
				),
		),
));
 ?>