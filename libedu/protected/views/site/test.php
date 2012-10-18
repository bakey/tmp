<?php
/*$this->Widget('ext.highcharts.HighchartsWidget', array(
		'options'=>array(
				'title' => array('text' => 'Fruit Consumption'),
				'xAxis' => array(
						'categories' => array('Apples', 'Bananas', 'Oranges')
				),
				'yAxis' => array(
						'title' => array('text' => 'Fruit eaten')
				),
				'series' => array(
						array('name' => 'Jane', 'data' => array(1, 0, 4)),
						array('name' => 'John', 'data' => array(5, 7, 3))
				)
		)
));*/

/*$this->widget('application.extensions.redactorjs.Redactor',array(
		'model'=>$model,
		'attribute'=>'post',
		'editorOptions' => array(
				'focus' => false,
				'style' => 'height:10px;',
		),
));
*/
?>
<script type="text/javascript">
$(".tooltip").tooltip({
    activation:         "hover",
    maxWidth:           "340px",
    title:              "This is a title",
    edgeOffset:         20,
    defaultPosition:    "right",
    delay:              100,
    fadeIn:             500,
    fadeOut:            500,
    attribute:          "data-tooltip",
    theme:              "blue",
    content:            "Sample <strong>content</strong>",
    enter:              function() {
                            alert("Enter")
                        },
    exit:               function() {
                            alert("Exit")
                        }
});
</script>
<a href="#" class="tooltip" title="This is a tooltip">A link with a tooltip</a>


