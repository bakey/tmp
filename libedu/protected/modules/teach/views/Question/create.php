<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
    'links'=>array('问答'=>array('/teach/question/myquestion'),'提问' ),
)); ?>

<h3>提问</h3>

<?php echo $this->renderPartial('_form', array('model'=>$model,'mycourse'=>$mycourse)); ?>