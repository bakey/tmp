<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
    'links'=>array('行政管理'=>'#', '班级管理'=>'#','创建班级'),
)); ?>

<h3>创建班级</h3>

<?php echo $this->renderPartial('_form', array('model'=>$model,'tinfo'=>$tinfo)); ?>