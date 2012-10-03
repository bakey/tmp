<?php
$this->widget('bootstrap.widgets.TbGridView', array(
		'dataProvider' => $dataProvider,
		'type' => 'bordered striped',
		'columns'=>array(
				array(
						'name'=>'第几节',
						'value'=>'$data["item_index"]',
						'type'=>'raw',
				),
				array(
						'name'=>'内容',
						'value'=>'$data["content"]',
						'type'=>'raw',
				),
				array(	
						'name' => '浏览',
						'value' => 'CHtml::link($data["view_post"] , $data["view_url"])',
						'type' => 'raw',
				),
				array(
						'name' => '最后更新时间',
						'value' => '$data["update_time"]',
						//'type'
				),
		),
));
?>