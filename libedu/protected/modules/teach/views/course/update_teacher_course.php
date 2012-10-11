<?php
/* @var $this CourseController */

$this->breadcrumbs=array(
	'课程管理'=>array('/teach/course/admin'),
	'课程资料',
);
?>


<?php
$this->renderPartial( '_show_teacher_item' , array( 'current_item' => $top_item) );
//echo"<div id=\"stitle\"><h3>第" . $top_item->edi_index . "章:" . $top_item->content . "<h3></div><br>";

//$this->renderPartial( '_show_teacher_item' , array('dataProvider' => $tracing_item) );

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

<h2>
<?php
/*foreach( $level_one_items as $single_item )
{
	echo "第" . $single_item->edi_index . "章   " . $single_item->content ;
	$item_table_id = "item-table-" . $single_item->id;	
	$html_options = array( 'onclick' => 'javascript:$.ajax( {
			url:"index.php?r=teach/course/loadchilditemastable&item=' . $single_item->id . '",
			success:function(response){
				var item_id = "#item-table-' . $single_item->id . '";
				$(item_id).html( response );
				$(item_id).toggle();
				//$(\'#item-table-' . $single_item->id . '\').html( response );	
					  		
		  	},
		})' );*/
?>
</h2>
