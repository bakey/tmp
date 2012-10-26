<?php
	foreach( $course_edi as $ce )
	{
		echo '<div class="dotbottom course_name">';
		echo '<span class="">';
		echo $ce['course']->name;
		echo '</span>';
		echo '<span style="margin-left:190px">';
		echo $ce['edition']->name;
		echo '</span>';
		echo '</div>';
	}
?>