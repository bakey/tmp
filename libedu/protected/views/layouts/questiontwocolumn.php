<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="span8">
	<div id="content">
		<?php echo $content; ?>
	</div><!-- content -->
</div>
<div class="span3">
	<?php $this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>true, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'问答首页', 'url'=>'#', 'active'=>true),
        array('label'=>'推荐的问题', 'url'=>'#'),
        array('label'=>'提问的知识点', 'url'=>'#'),
        array('label'=>'收藏的提问', 'url'=>'#'),
    ),
)); ?>
</div>
<?php $this->endContent(); ?>