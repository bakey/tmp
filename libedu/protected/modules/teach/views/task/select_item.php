<?php
$url = 'edition/ajaxFillTree&edition_id=' . $edition_id ;
$this->widget(
		'CTreeView',
		array(
				'animated'=>'fast', //quick animation
				'collapsed' => false,
				'url' => array( $url ),
		)
);
?>