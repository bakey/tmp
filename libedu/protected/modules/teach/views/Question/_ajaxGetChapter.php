<div class="carton tinyallpadding animated fadeIn">
<h2>选择章节</h2>
<div class="content">
<?php
/* @var $this UserController */
/* @var $data User */
	Yii::app()->getClientScript()->scriptMap=array(
										'jquery.js'=>false,
								);
	$url = 'question/ajaxFillTree&edition_id='.$eid->id;
		$this->widget(
			    'CTreeView',
				array(
					'id'=>'modaltreeview',
		            'animated'=>'fast', //quick animation
		            'collapsed' => false,
		            'unique'=>true,
		            'url' => array( $url ),
		            'toggle'=>'js:function(){$(this).parents(".modal").css("height",parseInt($(this).parents("#modaltreeview").height())+280+"px");}',
				)
		);
?>
</div>
<div class="container normaltoppadding">
	<div class="carton col_12 roundbordered tinytinyallpadding" id="selectedchapterforquestion">请选择一个章节，并点击提出问题按钮</div>
	<button class="col_4 offset_5 sugar" onclick="submitQuestion()">提出问题</button>
	<button class="col_3 sugar" onclick="closemodal();">取消</button>
</div>
</div>

