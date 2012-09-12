<?php
$this->breadcrumbs=array(
	'News Feeds'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List NewsFeed', 'url'=>array('index')),
	array('label'=>'Manage NewsFeed', 'url'=>array('admin')),
);
?>

<h1>创建通知</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>