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
	private $id;
	private $_uemail;
	
	public function authenticate(){
		$username=strtolower($this->username);
		$user=LibUser::model()->findByAttributes(array('user_name'=>$username));
		if($user===null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if(!$user->validatePassword($this->password,$user->salt))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else{
			$this->id=$user->id;
			$this->username=$user->user_name;
			$this->_uemail = $user->email;
			$this->errorCode=self::ERROR_NONE;
		}
		return $this->errorCode==self::ERROR_NONE;
	}
	
	public function getEmail(){
		return $this->_uemail;
	}

	public function getId(){
		return $this->id;
	}
}