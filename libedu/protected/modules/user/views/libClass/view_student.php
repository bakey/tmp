<div class="well">
<?php

$this->widget('bootstrap.widgets.TbGridView',
		array(
				'id'=>'student-view-id',
				'dataProvider'=>$dataProvider,
		)
);

?>
</div>