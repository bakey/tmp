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
			$this->errorCode=self::ERROR_NONE;
		}
		return $this->errorCode==self::ERROR_NONE;
	}
	
	public function getId()
	{
		return $this->_id;
	}

}