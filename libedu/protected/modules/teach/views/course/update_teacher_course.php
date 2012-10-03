<?php
/* @var $this CourseController */

$this->breadcrumbs=array(
	'课程管理'=>array('/teach/course/admin'),
	'课程资料',
);
?>
<link rel="stylesheet" type="text/css" href="/dev/libedu/css/my.css" />
<?php
echo"<div id=\"stitle\"><h3>第" . $top_item->edi_index . "章:" . $top_item->content . "<h3></div><br>";
$this->renderPartial( '_show_teacher_item' , array('dataProvider' => $tracing_item) );
/*$this->widget('bootstrap.widgets.TbGridView', array(
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
		),
));*/
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
	$item_table_id = "item-table-" . $single_item->id;	
	/*echo CHtml::image('images/show_item.jpg' , '' , array('href'=>'#' , 'ajax'=>array(
						'type'=>'POST',
						'url' => array('update'),
						//'data' => array('item'=>$single_item->id),
						'update' => '#item-table-' . $single_item->id ,
				) ) );*/
$html_options = array( 'onclick' => 'javascript:$.ajax( {
			url:"index.php?r=teach/course/loadchilditemastable&item=' . $single_item->id . '",
			success:function(response){
				$(\'#item-table-' . $single_item->id . '\').append( response );		  		
		  	},
		})' );
echo CHtml::image('images/show_item.jpg' , '' , $html_options );
echo '<h5><div id="' . $item_table_id . '"></div></h5>';
	echo "<br>";
} 
?>
</h3>
