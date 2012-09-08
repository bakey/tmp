<?php
$this->breadcrumbs=array(
	'News Feeds'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List NewsFeed', 'url'=>array('index')),
	array('label'=>'Create NewsFeed', 'url'=>array('create')),
	array('label'=>'View NewsFeed', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage NewsFeed', 'url'=>array('admin')),
);
?>

<h1>Update NewsFeed <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>