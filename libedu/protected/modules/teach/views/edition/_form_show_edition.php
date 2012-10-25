<?php
$this->widget('zii.widgets.grid.CGridView',
		array(
				'id'=>'edition-id',
				'dataProvider'=>$dataProvider,
		)
);
?>