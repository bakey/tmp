<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
    'links'=>array('用户中心'=>'#', '用户激活'=>'#','重新发送激活邮件'),
)); ?>

<div class="page-header">
  <h2>激活 <small>重新发送激活邮件成功</small></h2>
</div>


<?php 
	if(isset($msg)){
		echo '<div class="well"><p>'.$msg.'</p></div>';
	}
?>