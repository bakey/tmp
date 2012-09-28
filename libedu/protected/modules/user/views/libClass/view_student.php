<div class="well">
<?php

$this->widget('zii.widgets.grid.CGridView',
		array(
				'id'=>'student-view-id',
				'dataProvider'=>$dataProvider,
		)
);

?>
</div>