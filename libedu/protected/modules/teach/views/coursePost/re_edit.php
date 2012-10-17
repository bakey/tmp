<?php
Yii::app()->getClientScript()->scriptMap=array(
	'jquery.js'=>false,
);
?>
<ul class="tabs">
	<li class="active_tab side_bar_word" >
		<?php
			echo CHtml::link($item_model->content , array("index&item_id=" . $item_model->id) , array('rel'=>'external') );
		?>
	</li>
</ul>
<div class="tabs">
     <div id="tab_one" class="tab mytab">
     	<div>
        	<div class="content">
       			<?php
       				$this->renderPartial( '_edit_form' , array(
								'model'				 => $post_model,
								'base_auto_save_url' => $baseAutoSaveUrl,
								'base_create_url'    => $baseCreateUrl,
								'item_id'			 => $item_model->id,
							) ); 
       			?>
      		</div>
     	</div>
     </div>
</div>




