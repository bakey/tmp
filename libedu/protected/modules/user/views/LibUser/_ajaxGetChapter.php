<?php
/* @var $this UserController */
/* @var $data User */
	$url = 'edition/ajaxFillTree&edition_id='.$eid;
		$this->widget(
			    'CTreeView',
				array(
		            'animated'=>'fast', //quick animation
		            'collapsed' => false,
		            'url' => array( $url ), 
				)
		);
?>

