<div class="form" method="post">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'problem-form',
	'enableAjaxValidation'=>false,
)); ?>


	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
    
	<?php echo $form->labelEx($model,'类型'); ?>
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

	<div class="row">
		<?php echo $form->labelEx($model,'课程'); ?>
		<?php echo $form->textField($model,'course',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'course'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'题目来源'); ?>
		<?php echo $form->textField($model,'source',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'source'); ?>
	</div>
   
    <div class="row">
		<?php echo $form->labelEx($model,'题干'); ?>
		<?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->labelEx($model,'选项数: '); ?>
		<?php echo $form->error($model,'content'); ?>
	</div>

    <script type="text/javascript">
	function addInput()
	{
		if(document.getElementById("type").value==1 && document.getElementById("selectNum").value==1)
			document.getElementById('tempID').innerHTML='<label id="options">选项内容设置</label><label id="A">A<input type="text" name="A" /></label> <label id="B">B<input type="text" name="B" /></label><label id="C">C<input type="text" name="C" /></label><label id="D">D<input type="text" name="D" /></label><label id="Answers">答案</label><label id="A">A<input type="checkbox" name="same[]" value="A"></label><label id="B">B<input type="checkbox" name="same[]" value="B"></label><label id="C">C<input type="checkbox" name="same[]" value="C"></label><label id="D">D<input type="checkbox" name="same[]" value="D"></label>';
		else if(document.getElementById("type").value==1 && document.getElementById("selectNum").value==2)
			document.getElementById('tempID').innerHTML='<label id="options">选项内容设置</label><label id="A">A<input type="text" name="A" /></label><label id="B">B<input type="text" name="B" /></label><label id="C">C<input type="text" name="C" /></label><label id="D">D<input type="text" name="D" /></label><label id="E">E<input type="text" name="E"/></label><label id="Answers">答案</label><label id="A">A<input type="checkbox" name="same[]" value="A"></label><label id="B">B<input type="checkbox" name="same[]" value="B"></label><label id="C">C<input type="checkbox" name="same[]" value="C"></label><label id="D">D<input type="checkbox" name="same[]" value="D"></label><label id="E">E<input type="checkbox" name="same[]" value="E"></label>';
		else if(document.getElementById("type").value==1 && document.getElementById("selectNum").value==3)
			document.getElementById('tempID').innerHTML='<label id="options">选项内容设置 </label><label id="A">A<input type="text" name="A" /></label><label id="B">B<input type="text" name="B" /></label><label id="C">C<input type="text" name="C" /></label><label id="D">D<input type="text" name="D" /></label><label id="E">E<input type="text" name="E"/></label><label id="F">F<input type="text" name="F"/></label><label id="Answers">答案</label><label id="A">A<input type="checkbox" name="same[]" value="A"></label><label id="B">B<input type="checkbox" name="same[]" value="B"></label><label id="C">C<input type="checkbox" name="same[]" value="C"></label><label id="D">D<input type="checkbox" name="same[]" value="D"></label><label id="E">E<input type="checkbox" name="same[]" value="E"></label><label id="F">F<input type="checkbox" name="same[]" value="F"></label>';
		else if(document.getElementById("type").value==0 && document.getElementById("selectNum").value==1)
            document.getElementById('tempID').innerHTML='<label id="options">选项内容设置 </label><label id="A">A<input type="text" name="A" /></label> <label id="B">B<input type="text" name="B" /></label><label id="C">C<input type="text" name="C" /></label><label id="D">D<input type="text" name="D" /></label><label id="Answers">答案</label><label id="A">A<input type="radio" name="same" value="A"></label><label id="B">B<input type="radio" name="same" value="B"></label><label id="C">C<input type="radio" name="same" value="C"></label><label id="D">D<input type="radio" name="same" value="D"></label>';
		else if(document.getElementById("type").value==0 && document.getElementById("selectNum").value==2)
            document.getElementById('tempID').innerHTML='<label id="options">选项内容设置 </label><label id="A">A<input type="text" name="A" /></label><label id="B">B<input type="text" name="B" /></label><label id="C">C<input type="text" name="C" /></label><label id="D">D<input type="text" name="D" /></label><label id="E">E<input type="text" name="E"/></label><label id="Answers">答案</label><label id="A">A<input type="radio" name="same" value="A"></label><label id="B">B<input type="radio" name="same" value="B"></label><label id="C">C<input type="radio" name="same" value="C"></label><label id="D">D<input type="radio" name="same" value="D"></label><label id="E">E<input type="radio" name="same" value="E"></label>';
		else if(document.getElementById("type").value==0 && document.getElementById("selectNum").value==3)
            document.getElementById('tempID').innerHTML='<label id="options">选项内容设置</label><label id="A">A<input type="text" name="A" /></label><label id="B">B<input type="text" name="B" /></label><label id="C">C<input type="text" name="C" /></label><label id="D">D<input type="text" name="D" /></label><label id="E">E<input type="text" name="E"/></label><label id="F">F<input type="text" name="F"/></label><label id="Answers">答案</label><label id="A">A<input type="radio" name="same" value="A"></label><label id="B">B<input type="radio" name="same" value="B"></label><label id="C">C<input type="radio" name="same" value="C"></label><label id="D">D<input type="radio" name="same" value="D"></label><label id="E">E<input type="radio" name="same" value="E"></label><label id="F">F<input type="radio" name="same" value="F"></label>';
	}

</script>

	<select name="sel" id="selectNum" onchange="addInput()">
	<option value="1">4</option>
	<option value="2">5</option>
	<option value="3">6</option>
	</select>
	<div id="tempID"></div> 
    

		
	<div class="row" id="textarea">
		<?php echo $form->labelEx($model,'答案解析'); ?>
		<?php echo $form->textArea($model,'ans_explain',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'ans_explain'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? '创建' : '保存'); ?>
        <input type="reset" name="Clear" value="清空"> 
	</div>

	<script>
		window.onload=function(){
			addInput();
	}
	</script>

<?php $this->endWidget(); ?>

</div><!-- form -->