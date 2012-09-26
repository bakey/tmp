<?php
class ProfilePanel extends CWidget
{
     
    public function run()
    {
        $cusr = LibUser::model()->findByPk(Yii::app()->user->id);
        $this->render('_profilepanel',array('cusr'=>$cusr));
    }
}

?>