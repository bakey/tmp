<?php

class LibUserController extends Controller
{
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('LibUser',array(
			'criteria'=>array(
				'with'=>array('activation_record'),
			),
			'pagination'=>array('pageSize'=>15),
		));
		$this->render('index',array(
			'dProvider'=>$dataProvider,
		));
	}

	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionRegister(){
		$model=new LibUser;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['LibUser']))
		{
			$model->attributes=$_POST['LibUser'];
			if($model->save())
				$this->redirect(array('/site/login'));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionResendActivationCode($status = 2){
		//未完成
		$model = new LibUser;
		$form = new CForm('application.modules.user.views.LibUser.resendForm', $model);
		if($form->submitted('resendBtn')){
			if(LibUser::model()->resendActivationCode($_POST['LibUser']['email'])){
				$this->redirect(array('/user/libuser/resendactivationcode','status'=>1));
			}else{
				$this->redirect(array('/user/libuser/resendactivationcode','status'=>0));
			}
		}else{
			if($status == 1){
				$this->render('resendresult',array('msg' => '系统已经重新给您发送了一封激活电子邮件，请您检查您的邮箱，点击邮件中的链接激活您的账户。'));
			}else if($status == 0){
				$this->render('resend',array('msg' => '系统中没有您的电子邮箱地址，请您再次确认您输入的是您注册时填写的电子邮件地址','form'=>$form));
			}else if($status == 2){
				$this->render('resend', array('form'=>$form));
			}
		}
	}	

	public function actionActivate($aid){
		if(LibUser::model()->validateActivationCode($aid)){
			$this->render('active',array(
				'msg'=>'账户激活成功！',
				'result' => 1,
			));
		}else{
			$this->render('active',array(
				'msg'=>'您的帐户激活码不正确或已过期！',
				'result' => 0,
			));
		}
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=LibUser::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{	
		if(isset($_POST['ajax']) && $_POST['ajax']==='libuser-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}