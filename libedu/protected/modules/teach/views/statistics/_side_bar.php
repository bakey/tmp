
<ul class="tabs">
	<div id="tab_one" class="tab mytab" >
	<li class="tabheader side_bar_word" onclick="toggle(this , 'course_stat')">
        <h3>
        	课程统计<span class="iconclass min">H</span>
        </h3>
    </li>
    <li class="course_stat side_bar_word">
        <a href="#tab_one">热点统计</a>
    </li>
    <li class="course_stat side_bar_word">
        <a href="#tab_one">浏览统计</a>
    </li>
    <li class="course_stat side_bar_word">
        <a href="#tab_one">共建统计</a>
    </li>
    <li class="course_stat side_bar_word">
        <a href="#tab_one">来访统计</a>
    </li>
    <li class="task_stat side_bar_word tabheader" onclick="toggle(this , 'task_stat')">
        <h3>测试统计<span class="iconclass min">H</span></h3>
    </li>
    <li class=" side_bar_word current task_stat">
        <a href="<?php echo Yii::app()->createUrl("/teach/statistics"); ?>" rel="external">热点统计</a>
    </li>
    <li class="task_stat side_bar_word">
        <a href="#tab_one">得分统计</a>
    </li>
    <li class="task_stat side_bar_word">
        <a href="#tab_one">错题与知识点统计</a>
    </li>
    <li class="task_stat side_bar_word">
        <a href="#tab_one">共建统计</a>
    </li>
    <li class="qa_stat side_bar_word tabheader" onclick="toggle(this , 'qa_stat')">
        <h3>问答统计<span class="iconclass min">H</span></h3>
    </li>
    <li class="qa_stat side_bar_word">
        <a href="#tab_one">热点统计</a>
    </li>
    <li class="qa_stat side_bar_word">
        <a href="#tab_one">知识点统计</a>
    </li>
    <li class="qa_stat side_bar_word">
        <a href="#tab_one">学生统计</a>
    </li>
    <li class="side_bar_word qa_stat qa_item_stat">
        <a href="<?php echo Yii::app()->createUrl('/teach/statistics/getitemstat'); ?>" rel="external">章节统计</a>
    </li>
    </div>
</ul>