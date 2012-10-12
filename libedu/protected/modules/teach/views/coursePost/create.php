<?php
Yii::app()->getClientScript()->scriptMap=array(
	'jquery.js'=>false,
);
?>
<ul class="tabs">
<li class="active_tab">
		<?php
			echo $item_model->content; 
		?>
</li>
</ul>
 <div class="tabs">
     <div id="tab_one" class="tab mytab">
     	<div>
        	<div class="content">
       			<?php
       				$this->renderPartial( '_edit_form' , array(
								'model'				 => $model,
								'base_auto_save_url' => $base_auto_save_url,
								'base_create_url'    => $base_create_url,
								'item_id'			 => $item_model->id,
							) ); 
       			?>
      		</div>
     	</div>
     </div>
</div>




