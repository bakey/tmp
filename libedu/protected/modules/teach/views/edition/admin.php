<?php
Yii::app()->getClientScript()->scriptMap=array(
'jquery.js'=>false,
);
?>
<h1>教材管理</h1>
<a href="<?php echo Yii::app()->createUrl('/teach/edition/importedition'); ?>" rel="external">
	<button>导入教材</button>
</a>
<?php
?> 

<?php
$this->renderPartial('_form_show_edition', array( 'dataProvider'=>$dataProvider ) );
//$this->renderPartial('_form_add_edition' , array( 'model'=>$model,)	); 
?>