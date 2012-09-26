<?php
class SidebarMenu extends CWidget
{
     
    public function run()
    {
    	$cusc = UserSchool::model()->findByAttributes(array('user_id'=>Yii::app()->user->id,'school_id'=>Yii::app()->params['currentSchoolID'],'leave_time'=>null));
    	if($cusc->role == 2){
    		$this->render('_teachersidebarmenu');
    	}else{
    		$this->render('_studentsidebarmenu');
    	}
    }
}

?>