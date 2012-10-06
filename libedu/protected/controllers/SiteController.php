<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'

		$cschool = School::model()->findByPk(Yii::app()->params['currentSchoolID']);

		if(Yii::app()->user->isGuest) {
			$this->render('index',array('cschool'=>$cschool));
		}else{

			$res = array();
			$mycourselist = UserCourse::model()->findAllByAttributes(array('user_id'=>Yii::app()->user->id));
			foreach($mycourselist as $singlecourse){
				array_push($res, Course::model()->findByPk($singlecourse->course_id));	
			}
			if(Yii::app()->user->urole == 1){
				$this->render('stuindex',array('cschool'=>$cschool,'courselist'=>$res));
			}else if(Yii::app()->user->urole == 2){
				$this->render('lecindex',array('cschool'=>$cschool,'courselist'=>$res));
			}else if(Yii::app()->user->urole == 0){
				$this->render('adminindex',array('cschool'=>$cschool));
			}
		}
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
	
	public function actionTest()
	{
		//echo md5( "1234" . "123456" );
		//echo urldecode('http%2F%2FFai.wenku.baidu.com%252Fplay%26docid%3D5f34b8c55fbfc77da269b1d9%26fpn%3D5%26npn%3D5%26bookmark%3D0%257C0%26ext%3Ddoc%26readertype%3Dinternal%26newmark%3D0%257C0%26catal%3D0%26cdnurl%3Dhttp%253A%252F%252Fai.wenku.baidu.com%252Fplay%26cid%3D62%26cid1%3D1%26cid2%3D2%26cid3%3D62%26isChrome%3D1%26title%3D%25E6%25B3%25A8%25E5%2586%258C%25E7%2594%25B5%25E6%25B0%2594%25E5%25B7%25A5%25E7%25A8%258B%25E5%25B8%2588%25E5%25A4%258D%25E4%25B9%25A0%25E5%25BF%2583%25E5%25BE%2597');
		//require_once( 'simple.php' );
		//$str = "<p><br></p>";
		//$str2 = "abcdedg";
		//echo strlen( strip_tags($str) );
		//$model=new ContactForm;
		$model = new CoursePost;
		$this->render('test' , array('model'=>$model));
	}

	public function actionTimelineTest(){
		$this->render('timeline');
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()){
				if(Yii::app()->user->ustatus < 2){
					$this->redirect(array('/user/libuser/notactived'));
				}else{
					$this->redirect(Yii::app()->user->returnUrl);
				}
			}
				
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}