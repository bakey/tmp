	<?php 
    		$this->widget('bootstrap.widgets.TbListView', array(
    				'dataProvider'=>$problem_data,
    				'itemView'=>'_view_problem',
    		));
    	?>