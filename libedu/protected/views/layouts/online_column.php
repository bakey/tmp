<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="span8">
	<div id="content">
		<?php echo $content; ?>
	</div><!-- content -->
</div>
<div class="span3">
	<div id="sidebar">
		<?php 
		
		$this->widget('bootstrap.widgets.TbMenu', array(
				'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
				'stacked'=>true, // whether this is a stacked menu
				'items'=>$this->menu,
				'htmlOptions'=>array(
					'style' => 'margin-top:100px'
				),
		));
		?>
	</div>
</div>
<?php $this->endContent(); ?>