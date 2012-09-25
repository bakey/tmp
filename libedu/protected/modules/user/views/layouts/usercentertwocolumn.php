<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="span-19">
	<div id="content">
		<?php echo $content; ?>
	</div><!-- content -->
</div>
<div class="span-5 last">
	<?php $this->widget('application.modules.user.widgets.profilepanel'); ?>
	<div id="sidebar">
	<p>hi</p>
	</div><!-- sidebar -->

</div>
<?php $this->endContent(); ?>