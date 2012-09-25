<?php

$this->breadcrumbs=array(
		'view_student',
);
?>

</div><!-- search-form -->

<?php

$this->widget('zii.widgets.grid.CGridView',
		array(
				'dataProvider'=>$dataProvider,
		)
);

?>
		
	