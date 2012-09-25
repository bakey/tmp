<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	private $_id; 
	private $ROLE_UNKNOWN_ROLE = -1;
	/*
	 * 通过查询user_class表，来确定该用户目前在系统中主要为什么角色。
	 * 1代表学生，2代表老师
	 */
	
	private function getUserRole( $uid )
	{
		$msg = sprintf("user[%d] role = ", $uid );
		$ret = $this->ROLE_UNKNOWN_ROLE;
		$student_role = Yii::app()->params['user_role_student'];
		$teacher_role = Yii::app()->params['user_role_teacher'];
		$exist_as_teacher = LibUserClass::model()->exists(
				'teacher_id=:tid',
				array(
						':tid' => $uid,
						)
				);
		$exist_as_student = LibUserClass::model()->exists(
					'student_id=:sid',
					array(
							':sid' => $uid,
						 )
				);
		if ( $exist_as_teacher ) {
			$msg .= "[teacher]";
			$ret = $teacher_role;
		}
		else if ( $exist_as_student ) {
			$msg .= "[student]";
			$ret = $student_role;
		}else {
			$msg .= "[unknown role]";
			$ret = $this->ROLE_UNKNOWN_ROLE;
		}
		Yii::log( $msg , 'notice' );
		return $ret;		
	}
	
	public function authenticate(){
		$username=strtolower($this->username);
		$user=LibUser::model()->findByAttributes(array('email'=>$username));
		if($user===null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if(!$user->validatePassword($this->password,$user->salt))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else{
			$usch=UserSchool::model()->findByPk($user->id);
			if($usch){
				$this->setState('urole',$usch->role);
			}
			$this->setState('ustatus',$user->status);
			$this->setState('uemail',$user->email);
			$this->setState('real_name',$user->user_profile->real_name );
			$this->_id = $user->id;
			$this->setState( 'user_role', $this->getUserRole($this->_id) );
			$this->errorCode=self::ERROR_NONE;
		}
		return $this->errorCode==self::ERROR_NONE;
	}
	
	public function getId()
	{
		return $this->_id;
	}

}