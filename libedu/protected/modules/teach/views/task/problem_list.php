<?php 
	foreach( $problem_data->getData() as $problem )
    		{
    			echo '<div class="carton col_12 tinytinyallpadding">';
    			$this->renderPartial( '_view_problem' , array('data' => $problem ) );
    			echo '</div>';
    		}
?>