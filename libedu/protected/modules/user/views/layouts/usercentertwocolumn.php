<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="span-18">
	<div id="content">
		<?php echo $content; ?>
	</div><!-- content -->
</div>
<div class="span-6 last">
	<?php $this->widget('application.modules.user.widgets.profilepanel'); ?>
	<?php $this->widget('application.modules.user.widgets.sidebarmenu'); ?>
</div>
<?php $this->endContent(); ?>