<?php
/* @var $this CourseController */

$this->breadcrumbs=array(
	'课程管理'=>array('/teach/course/admin'),
	'Update',
);
?>
<link rel="stylesheet" type="text/css" href="/dev/libedu/css/my.css" />
<?php
echo"<div id=\"stitle\"><h3>第" . $top_item->edi_index . "章:" . $top_item->content . "<h3></div><br>";
$this->widget('bootstrap.widgets.TbGridView', array(
		'dataProvider' => $tracing_item,
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
						//'value' => 'CHtml::link($data["content"] , $data["url"])',
						'type'=>'raw',
				),
				array(
						'name'=>'操作',
						'value'=>'CHtml::link($data["operate"] , $data["url"])',
						'type' => 'raw',
				),
		),
));
/*
foreach( $tracing_item as $item )
{
	$text = sprintf("第%d节 : %s" , $item['item_index'] , $item['content']);
	echo CHtml::link( $text , $item['url'] );
	echo "<br>";
} 
*/
/*$this->widget(
	    'CTreeView',
		array(
            'animated'=>'fast', //quick animation
            'collapsed' => false,
            'url' => array( $ajax_load_url ), 
		)
);
*/
?>
<div id="stitle"><h3>全部课程</h3></div>
<h3>
<?php
foreach( $level_one_items as $single_item )
{
	echo "第" . $single_item->edi_index . "章   " . $single_item->content ;	
	/*echo CHtml::image('images/show_item.jpg' , '' , array('href'=>'#' , 'ajax'=>array(
						'type'=>'POST',
						'url' => array(),
						'data' => array('item'=>$single_item->id),
						'update' => '#update',
				) ) );*/
	echo "<br>";
} 
?>
</h3>
