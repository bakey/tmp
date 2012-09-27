<form method="post">
<?php echo '试卷浏览'; ?><br><br>
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
				$contents=$data[$i][0]->content; 
				$str=explode("\n",$contents);

				echo CHtml::encode($data[$i][0]->id);
				echo CHtml::encode('.  ');
				echo CHtml::encode('('.$data[$i][0]->source.')  ');
				echo CHtml::encode($str[0]);
				echo '<br>';
					
				if($data[$i][0]->type==0)
				{
					
					for($j=1;$j<count($str);$j++)
					{
						echo '<br>';
						$var=65+$j-1;
						?>
						<input type="radio" name=<?php echo strval($data[$i][0]->id); ?> value=<?php echo chr($var); ?> />	   
						
						<?php	echo CHtml::label(chr($var),false);
						echo CHtml::label('   ',false);
						echo CHtml::encode($str[$j]);
						echo CHtml::label('      ',false);
					}
				}
				else if($data[$i][0]->type==1)
				{
					for($j=1;$j<count($str);$j++)
					{
						echo '<br>';
						$var=65+$j-1;
						?>
						
					  <input type="checkbox" name="<?php echo strval($data[$i][0]->id); ?>"[] value="<?php echo chr($var); ?>">
						
					<?php			
						echo CHtml::label(chr($var),false);
						echo CHtml::label('   ',false);
						echo CHtml::encode($str[$j]);
						echo CHtml::label('      ',false);
					}
				}
					
				echo '<br><br>';
			
				for($j=0;$j<15;$j++)
					echo '&nbsp';

				echo '&nbsp&nbsp&nbsp';

				echo '<hr size="3" noshade="noshade"/>';
				$i++;
		     } 
		}
		pagelist($page,$pagecount,$rdcount,Yii::app()->getRequest()->getUrl().'&page=',$pageSize);
        echo '<br><br>';
        echo CHtml::Button('添加考生',array(
			'submit'=>array('task/addExaminee','taskid'=>$id),
			'params'=>array('command'=>'addExaminee','id'=>$id),
			));  
?>

<?php
function pagelist($page,$pagecount,$totalrecord,$url,$pagesize)
{
	if($page=="" || $page>$pagecount)
		exit();
	if($page==1)
		echo("记录".$totalrecord."�?�?".$pagecount."�?每页".$pagesize."�?");
	else
        echo("记录".$totalrecord."�?�?".$pagecount."�?每页".$pagesize."�?a href=".$url."1>&nbsp;
	首页</a>&nbsp;");

	if($page>1)
	{
		echo("<a href=".$url.($page-1).">&nbsp;上一�?nbsp;</a>"); 
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
		echo("<a href=".$url.($page+1).">&nbsp;下一�?nbsp;</a>");
	}
	echo ("<a href=".$url.$pagecount.">&nbsp;末页</a>");
}
?>
</form>