
<?php
		$page=isset($_GET['page']) ? $_GET['page']:1;
		if(($nNumRows=count($data))<=0)
		{
			echo "<p align=center>没有相关题目的记录";
			exit;
		}
		
		$rdcount=count($data);
        if($rdcount)
		{
			$pageSize=5;
			$pagecount=($rdcount%$pageSize)?(int)($rdcount/$pageSize)+1:$rdcount/$pageSize;
		    $i=($page-1)*$pageSize;
            while($i<$page*$pageSize && $i<count($data))
		    {
				$contents=$data[$i]->content; 
				$str=explode("\n",$contents);

				echo CHtml::encode($data[$i]->id+1);
				echo CHtml::encode('.  ');
				echo CHtml::encode('('.$data[$i]->source.')  ');
				echo CHtml::encode($str[0]);
				echo '<br>';
				if($data[$i]->type==0)
				{
					for($j=1;$j<count($str);$j++)
					{
						echo '<br>';
						echo CHtml::radioButton('radio');
						$var=65+$j-1;
						echo CHtml::label(chr($var),false);
						echo CHtml::label('   ',false);
						echo CHtml::encode($str[$j]);
						echo CHtml::label('      ',false);
					}
				}
				else if($data[$i]->type==1)
				{
					for($j=1;$j<count($str);$j++)
					{
						echo '<br>';
						echo CHtml::checkbox('checkbox');
						$var=65+$j-1;
						echo CHtml::label(chr($var),false);
						echo CHtml::label('   ',false);
						echo CHtml::encode($str[$j]);
						echo CHtml::label('      ',false);
					}
				}
				echo '<br><br>';
				echo CHtml::label('参考答案:    ',false);
				echo CHtml::label($data[$i]->reference_ans,false);
				echo CHtml::label('       题目类型:   ',false);
				echo CHtml::label($data[$i]->getType($data[$i]->type),false);
				echo '<br>';
				echo CHtml::label('难度:    ',false);
				echo CHtml::label($data[$i]->getDifficulty($data[$i]->difficulty),false);
				echo CHtml::label('        使用次数:  ',false);
				echo CHtml::label($data[$i]->use_count,false);
				echo CHtml::label('       题目入库时间:  ',false);
				echo CHtml::label($data[$i]->create_time,false);
				for($j=0;$j<15;$j++)
					echo '&nbsp';

				echo '<script>
				function yanzheng(obj)
				{
					if(/[^0-9]/g.test(obj.value))
					{
					alert("输入的分数应该是数字!");
					document.getElementById("txtscore").controls.play();
					obj.select();
					}
				}</script>';
			 
				echo '选择本题   ';
				?>
				
				<input type="checkbox" name="same[]" value=<?php echo $data[$i]->id?> />
			    <input type="text" name="scores[]" />

			<?php	echo '<hr size="3" noshade="noshade"/>';
				$i++;
		     } 
		}
		pagelist($page,$pagecount,$rdcount,Yii::app()->getRequest()->getUrl().'&page=',$pageSize);
?>

<?php
function pagelist($page,$pagecount,$totalrecord,$url,$pagesize)
{
	if($page=="" || $page>$pagecount)
		exit();
	if($page==1)
		echo("记录".$totalrecord."条 共".$pagecount."页 每页".$pagesize."条.");
	else
        echo("记录".$totalrecord."条 共".$pagecount."页 每页".$pagesize."条<a href=".$url."1>&nbsp;
	首页</a>&nbsp;");

	if($page>1)
	{
		echo("<a href=".$url.($page-1).">&nbsp;上一页&nbsp;</a>"); 
	}
	if($page+1>$pagecount)
	{
		$current=$pagecount;
	}
	else
		$current=$page+1;
	for($i=$page;$i<=$current;$i++)
	{
		echo("<a href=".$url."$i class='sf'> $i </a>");
	}
	if($pagecount>$page)
	{
		echo("<a href=".$url.($page+1).">&nbsp;下一页&nbsp;</a>");
	}
	if($page<$pagecount)
	{
		echo ("<a href=".$url.$pagecount.">&nbsp;末页</a>");
	}
}
?>
