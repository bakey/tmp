<?php
/*$this->widget('bootstrap.widgets.TbGridView', array(
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
						'name'=>'新建',
						'value'=>'CHtml::link($data["new_post"] , $data["new_url"])',
						'type' => 'raw',
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
*/
?>
<ul class="thumbnails">
<?php
    if ( count($dataProvider->getData()) == 0 )
    {
    	?>
    	<li class="span3">
			<div class="thumbnail linkthumbnail">
				<div class="caption">
						此章下面没有数据			
				</div>
			</div>
		</li>
    	
    	<?php 
    	return ;
    }
foreach( $dataProvider->getData() as $data )
{?>
<li class="span3">
<div class="thumbnail linkthumbnail">
	<div class="caption">
<?php 
	echo "第" . $data['item_index'] . "节: " . $data['content'] . "<br>";
	echo "更新日期: " . $data['update_time'] . "<br>";
	echo CHtml::link($data["view_post"] , $data["view_url"]) . "<br>";
	echo CHtml::link($data["new_post"] , $data["new_url"]);
}
?>
</div>
</div>
</li>
</ul>