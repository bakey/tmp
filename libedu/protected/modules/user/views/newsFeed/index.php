<?php
$this->breadcrumbs=array(
	'News Feeds',
);

$this->menu=array(
	array('label'=>'Create NewsFeed', 'url'=>array('create')),
	array('label'=>'Manage NewsFeed', 'url'=>array('admin')),
);
?>

<h1>News Feeds</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
