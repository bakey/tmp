<?php
$editions=CourseEdition::model()->findAll();
?>
<form method="post">
<?php
for($i=0;$i<count($editions)-1;$i++)
{
	echo CHtml::radioButton("edition",false,array("value"=>$editions[$i]->id,"id"=>"edition"));
	echo $editions[$i]->name;
	echo '<br>';
}
echo CHtml::radioButton("edition",true,array("value"=>$editions[count($editions)-1]->id,"id"=>"edition"));
echo $editions[count($editions)-1]->name;
echo '<br>';
?>

<script>
  $(document).ready(function(){
	  $(":radio").each(function(){
		  $(this).click(function(){
			  if(this.checked==true){
				  var name="editionid",value=this.value;
				  document.cookie=name+"="+value+";"		  
			  }
		  });
	  });
});
</script>

<?php
$courseid=$_COOKIE['courseid'];
$editionid=$_COOKIE['editionid'];
echo CHtml::ajaxSubmitButton('提交',$this->createUrl('course/addCourseEdition',array('id'=>$courseid,'edition'=>$_COOKIE['editionid'])),
	array('success'=>'function(){$("#mydialog").dialog("close"); }'));
echo CHtml::ajaxSubmitButton('关闭','',array('success'=>'function(){$("#mydialog").dialog("close"); }'));

?>

