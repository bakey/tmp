
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'problem-form',
		'enableAjaxValidation'=>true,
		'action'=>'index.php?r=teach/problem/create',
)); ?>
<h1><font color="#FF0000">关联相关知识点</font></h1>


<?php
		$list_data = CHtml::listData( KnowledgePoint::model()->findAll(), 'id','name') ;
		foreach( $list_data as $index=>$value )
		{
			echo('<input type="checkbox" name="Problem[problem_cb][]" value="' . $index . '">' . $value . "</input><br>");
		}
	
	?>


	<?php echo $form->errorSummary($model); ?>    
	<?php echo $form->labelEx($model,'题型'); ?>
    <select name="topic" id="type" onchange="addInput()">
	<option value="0">单项选择</option>
	<option value="1">多项选择</option>
	<option value="2">填空题</option>
	<option value="3">问答题</option>
	</select>
	<div id="typeID"></div>

    <div class="row">
		<?php echo $form->labelEx($model,'难度'); ?>
		<?php echo $form->dropDownList($model,'difficulty',$model->getDifficultyLevel()); ?>
		<?php echo $form->error($model,'difficulty'); ?>
	</div>
<?php 
		echo $form->labelEx($model,'科目'); 
		echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>255)); 
		echo $form->error($model,'subject'); 
		//echo("选择科目 <br>");
		//echo CHtml::dropDownList( 'subject_list','', $subjectList , array() ); 
?>

    <div class="row">
		<?php echo $form->labelEx($model,'题目来源'); ?>
		<?php echo $form->textField($model,'source',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'source'); ?>
	</div>
		
   
    <div class="row">
		<?php echo $form->labelEx($model,'选项数: '); ?>
		<?php echo $form->error($model,'content'); ?>
	</div>


    <script type="text/javascript">
	function addInput()
	{	
		var newHTML = "";
		if( $('#type').val()==1 && $('#selectNum').val() == 1) {
			/*$('#tempID').innerHTML='<label id="options">选项内容设置</label><label id="A">A<input type="text" name="A" /> \
				</label> <label id="B">B<input type="text" name="B" /></label><label id="C">C<input type="text" name="C" /></label> \
				<label id="D">D<input type="text" name="D" /></label><label id="Answers">答案</label> \
				<label id="A">A<input type="checkbox" name="same[]" value="A"></label><label id="B">B<input type="checkbox" name="same[]" value="B"></label>\
				<label id="C">C<input type="checkbox" name="same[]" value="C"></label><label id="D">D<input type="checkbox" name="same[]" value="D"></label>';*/
			newHTML='<label id="options">选项内容设置</label><label id="A">A<input type="text" name="A" /></label> <label id="B">B<input type="text" name="B" /></label><label id="C">C<input type="text" name="C" /></label><label id="D">D<input type="text" name="D" /></label><label id="Answers">答案</label><label id="A">A<input type="checkbox" name="same[]" value="A"></label><label id="B">B<input type="checkbox" name="same[]" value="B"></label><label id="C">C<input type="checkbox" name="same[]" value="C"></label><label id="D">D<input type="checkbox" name="same[]" value="D"></label>';
		}
		else if( $('#type').val() == 1 && $('#selectNum').val() == 2) {
			newHTML='<label id="options">选项内容设置</label><label id="A">A<input type="text" name="A" /></label><label id="B">B<input type="text" name="B" /></label><label id="C">C<input type="text" name="C" /></label><label id="D">D<input type="text" name="D" /></label><label id="E">E<input type="text" name="E"/></label><label id="Answers">答案</label><label id="A">A<input type="checkbox" name="same[]" value="A"></label><label id="B">B<input type="checkbox" name="same[]" value="B"></label><label id="C">C<input type="checkbox" name="same[]" value="C"></label><label id="D">D<input type="checkbox" name="same[]" value="D"></label><label id="E">E<input type="checkbox" name="same[]" value="E"></label>';

		}
		else if( $('#type').val() == 1 && $('#selectNum').val() == 3) {
			newHTML='<label id="options">选项内容设置 </label><label id="A">A<input type="text" name="A" /></label><label id="B">B<input type="text" name="B" /></label><label id="C">C<input type="text" name="C" /></label><label id="D">D<input type="text" name="D" /></label><label id="E">E<input type="text" name="E"/></label><label id="F">F<input type="text" name="F"/></label><label id="Answers">答案</label><label id="A">A<input type="checkbox" name="same[]" value="A"></label><label id="B">B<input type="checkbox" name="same[]" value="B"></label><label id="C">C<input type="checkbox" name="same[]" value="C"></label><label id="D">D<input type="checkbox" name="same[]" value="D"></label><label id="E">E<input type="checkbox" name="same[]" value="E"></label><label id="F">F<input type="checkbox" name="same[]" value="F"></label>';

		}
		else if( $('#type').val() ==0 && $('#selectNum').val()==1) {
            newHTML='<label id="options">选项内容设置 </label><label id="A">A<input type="text" name="A" /></label> <label id="B">B<input type="text" name="B" /></label><label id="C">C<input type="text" name="C" /></label><label id="D">D<input type="text" name="D" /></label><label id="Answers">答案</label><label id="A">A<input type="radio" name="same" value="A"></label><label id="B">B<input type="radio" name="same" value="B"></label><label id="C">C<input type="radio" name="same" value="C"></label><label id="D">D<input type="radio" name="same" value="D"></label>';

		}
		else if( $('#type').val() ==0 && $('#selectNum').val()==2) {
			newHTML = '<label id="options">选项内容设置 </label><label id="A">A<input type="text" name="A" /></label><label id="B">B<input type="text" name="B" /></label><label id="C">C<input type="text" name="C" /></label><label id="D">D<input type="text" name="D" /></label><label id="E">E<input type="text" name="E"/></label><label id="Answers">答案</label><label id="A">A<input type="radio" name="same" value="A"></label><label id="B">B<input type="radio" name="same" value="B"></label><label id="C">C<input type="radio" name="same" value="C"></label><label id="D">D<input type="radio" name="same" value="D"></label><label id="E">E<input type="radio" name="same" value="E"></label>';
		}
		else if( $('#type').val() ==0 && $('#selectNum').val()==3) {
			newHTML='<label id="options">选项内容设置</label><label id="A">A<input type="text" name="A" /></label><label id="B">B<input type="text" name="B" /></label><label id="C">C<input type="text" name="C" /></label><label id="D">D<input type="text" name="D" /></label><label id="E">E<input type="text" name="E"/></label><label id="F">F<input type="text" name="F"/></label><label id="Answers">答案</label><label id="A">A<input type="radio" name="same" value="A"></label><label id="B">B<input type="radio" name="same" value="B"></label><label id="C">C<input type="radio" name="same" value="C"></label><label id="D">D<input type="radio" name="same" value="D"></label><label id="E">E<input type="radio" name="same" value="E"></label><label id="F">F<input type="radio" name="same" value="F"></label>';
		}
		$('#tempID').html( newHTML );
	}

</script>

	<select name="sel" id="selectNum" onchange="addInput()">
	<option value="1">4</option>
	<option value="2">5</option>
	<option value="3">6</option>
	</select>
	<div id="tempID"></div> 
    



	<script>
		window.onload=function(){
			addInput();
	}
	</script>
<?php echo $form->labelEx($model,'题干'); ?>
<?php
	$this->widget('application.extensions.redactorjs.Redactor',array(
		'model'=>$model,
		'attribute'=>'content',
		'editorOptions' => array(
			'imageUpload' => Yii::app()->createAbsoluteUrl('teach/problem/upload'),
			'focus' => false,
		),
	));
?>
<?php
	echo("参考答案:");
	$this->widget('application.extensions.redactorjs.Redactor',array(
		'model'=>$model,
		'attribute'=>'ans_explain',
		'editorOptions' => array(
			'focus' => false,
		//'imageUpload' => Yii::app()->createAbsoluteUrl('teach/coursepost/upload'),
		)
	));
?>

<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? '创建' : '保存'); ?>
        <input type="reset" name="Clear" value="清空"> 
	</div>
<div class="row buttons">
	</div>
	<?php $this->endWidget(); ?>
	

</div><!-- form -->
		
	