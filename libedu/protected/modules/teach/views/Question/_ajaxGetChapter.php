<p>选择章节</p>
<?php
/* @var $this UserController */
/* @var $data User */
	$url = 'question/ajaxFillTree&edition_id='.$eid->id;
		$this->widget(
			    'CTreeView',
				array(
		            'animated'=>'fast', //quick animation
		            'collapsed' => false,
		            'url' => array( $url ),
				)
		);
?>

