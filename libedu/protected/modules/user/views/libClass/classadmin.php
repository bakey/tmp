<?php
/* @var $this LibClassController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Lib Classes',
);

$this->menu=array(
	array('label'=>'Create LibClass', 'url'=>array('create')),
	array('label'=>'Manage LibClass', 'url'=>array('admin')),
);
?>

<h1>Lib Classes</h1>

<?php 
/*$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
));
*/ 
?>

<div class="tabbable tabs-left well"> <!-- Only required for left/right tabs -->
  <ul class="nav nav-tabs" id="myTab">
    <li class="active"><a href="#class1" data-toggle="tab">Section 1</a></li>
    <li><a href="#tab2" data-toggle="tab">Section 2</a></li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane active" id="class1" rel="1">
      <p>I'm in Section 1.</p>
    </div>
    <div class="tab-pane" id="tab2">
      <p>Howdy, I'm in Section 2.</p>
    </div>
  </div>
</div>


<script type = "text/javascript">
	$(document).ready(function(){
		var baseUrl = '<?php echo Yii::app()->createUrl("/user/libclass/loadclassinfo"); ?>';
		$('#class1').load(baseUrl+'&cid='+$('#class1').attr('rel'), function() {
            $('#myTab').tab(); //initialize tabs
        });
		$('#myTab').bind('show', function(e) {
       		var pattern=/#.+/gi;
      		var contentID = e.target.toString().match(pattern)[0];
		});
	});
</script>