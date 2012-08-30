<?php

?>

<h1>View Edition </h1>

<?php $this->widget('zii.widgets.grid.CGridView',
		array('dataProvider'=>$dataProvider)
	);
