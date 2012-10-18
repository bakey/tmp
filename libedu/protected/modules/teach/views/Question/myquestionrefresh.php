<?php 

Yii::app()->getClientScript()->scriptMap=array(
										'jquery.js'=>false,
										'styles.css'=>false,
										'pager.css'=>false,
								);
					$this->widget('zii.widgets.CListView', array(
						'dataProvider'=>$dataProvider,
						'itemView'=>'_view',
						 'summaryText'=>'',
					)); ?>