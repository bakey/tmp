<?php 
	foreach( $problem_data->getData() as $problem )
    		{
    			echo '<div id="singleproblem'.$problem->id.'" class="carton col_12 tinyallpadding normalbottommargin problemcarton">';
    			$this->renderPartial( '_view_problem' , array('data' => $problem ) );
    			echo '</div>';
    		}
?>