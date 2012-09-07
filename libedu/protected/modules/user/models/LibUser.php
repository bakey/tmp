<?php

/**
 * This is the model class for table "tbl_user".
 *
 * The followings are the available columns in table 'tbl_user':
 * @property integer $id
 * @property string $user_name
 * @property string $mobile
 * @property string $email
 * @property string $password
 * @property string $salt
 * @property integer $status
 */
class LibUser extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */

	public $repeatpassword = null;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_name, email, password,repeatpassword', 'required'),
			array('user_name, email, mobile', 'unique'),
			array('email', 'email'),
			array('mobile','match', 'pattern'=>'/^(1(([35][0-9])|(47)|[8][01236789]))\d{8}$/'),
			array('user_name, mobile, email, password', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_name, mobile, email', 'safe', 'on'=>'search'),
			array('repeatpassword', 'compare', 'compareAttribute'=>'password'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'activation_record'=>array(self::HAS_ONE,'UserActive','uid'),
			'user_profile'=>array(self::HAS_ONE,'Profile','uid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => '用户ID',
			'user_name' => '用户名',
			'mobile' => '手机号码',
			'email' => '电子邮件',
			'password' => '密码',
			'salt' => 'Salt',
			'status' => 'Status',
			'repeatpassword'=>'密码确认'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('user_name',$this->user_name,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('salt',$this->salt,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function validatePassword($password,$salt){
		return $this->hashPassword($password,$salt)===$this->password;
	}
	
	public function hashPassword($password,$salt){
		return md5($password.$salt);
	}

	public function validateActivationCode($aid){
		$usractive = new UserActive;
		$res = $usractive->findByAttributes(array('active_id' => $aid ));
		if(!$res){
			return false;
		}else{
			$cusr = $this->findByPk($res->uid);
			$cusr->status = 2;
			$cusr->save();
			$usractive->deleteByPk($res->uid);
			return true;
		}
	}

	public function resendActivationCode($uemail){
		$res = $this->findByAttributes(array('email' => $uemail));
		if(!$res){
			return false;
		} else if($res->status != 1){
			return false;
		}else{
			return true;
		}
	}


	public function beforeSave(){
		if ($this->isNewRecord){
			$this->status = 1;
			$this->salt = 'libedu'.time().$this->user_name;
			$this->password = $this->hashPassword($this->password,$this->salt);
		}else{
			if($this->repeatpassword != null)
				$this->repeatpassword = $this->password;
		}
		return parent::beforeSave();
	}

	
	public function validateUserFromArray($stuinfo = null,$schoolid){
		if(!$stuinfo){
			return null;
		}
		$result = array();
		$ttl = -1;
		foreach($stuinfo as $singlestu){
			$usc = new UserSchool;
			$cres = $usc->findByAttributes(array('school_id'=>$schoolid,'school_unique_id'=>$singlestu['学号']));
			$ttl ++;
			$result[$ttl] = $singlestu;
			// check if the record is a replica
			$result[$ttl]['filreason'] = '';
			if(!$cres){				
				$cls = new LibClass;
				$ccls = $cls->findByPk($singlestu['班级ID']);
				if(!$ccls){
					$result[$ttl]['filreason'] = '该学生所在班级不存在，请先建立班级';	
				}
			}else{
				$result[$ttl]['failreason'] = '该学生在系统中已存在';
			}
		}
		return $result;
	}

	public function addUserFromArray($stuinfo = null,$schoolid){
		$result = array('status'=>0,'total'=>0,'success'=>0,'fail'=>0);
		if(!$stuinfo){
			$result['status'] = -1;
			return $result;
		}
		$ttlRec = 0;
		$secRec = 0;
		$failRec = 0;
		foreach($stuinfo as $singlestu){
			$usc = new UserSchool;
			$cres = $usc->findByAttributes(array('school_id'=>$schoolid,'school_unique_id'=>$singlestu['学号']));
			
			// check if the record is a replica
			if(!$cres){
				$cusr = new LibUser;
				$tempusername = md5(uniqid());
				$cusr->user_name = $tempusername;
				$cusr->password = md5(uniqid());
				$cusr->email = md5(uniqid()).'@someschool.com';
				$cusr->mobile = '99999999999';

				//create user and create school/class student relation record
				if($cusr->save(false)){
					$insertedStu = $cusr->findByAttributes(array('user_name' => $tempusername));
					
					//save realname into the user's profile
					$cprof = new Profile;
					$insertedStuProfile = $cprof->findByPk($insertedStu->id);
					$insertedStuProfile->real_name = $singlestu['姓名'];

					//create school student relation
					$usc = new UserSchool;
					$usc->user_id = $insertedStu->id;
					$usc->school_id = $schoolid;
					$usc->school_unique_id = $singlestu['学号'];
					$usc->role = 1; //for now 1 means student

					//create class student relation
					$cls = new LibClass;
					$ccls = $cls->findByPk($singlestu['班级ID']);

					$ucls = new LibUserClass;
					$ucls->student_id = $insertedStu->id;
					$ucls->teacher_id = $ccls->classhead_id;
					$ucls->class_id = $ccls->id;

					if($insertedStuProfile->save()&&$usc->save()&&$ucls->save()){
						$ttlRec ++;
						$secRec ++;	
					}else{
						$ttlRec ++;
						$failRec ++;
					}
				}else{
					$ttlRec ++;
					$failRec ++;
				}
			}else{
				$ttlRec ++;
				$failRec ++;	
			}
		}
		if($failRec == 0){
			$result['status'] = 1;	
		}
		$result['total'] = $ttlRec;
		$result['success'] = $secRec;
		$result['fail'] = $failRec;

		return $result;
		
	}

	public function afterSave(){
		if ($this->isNewRecord){
			//get inserted user info (getInsertedID() not working) and generate activation code
			$usractive = new UserActive;
			$insertedUser = $this->findByAttributes(array('user_name'=>$this->user_name));
			$usractive->uid = $insertedUser->id;
			$aid = md5($this->email.$this->mobile.time());
			$usractive->active_id = $aid;
			$usractive->create_time = date('Y-m-d H:i:s');
			$res = $usractive->save();

			//send activation email

			if($insertedUser->mobile != '99999999999'){
				$mailer = new Emailer($insertedUser->email,'User_Real_Name_To_Be_Done_Add_Profile_Table');
				$mailer->setMsgSubject('激活您的LibSchool帐号');
				$mailer->setMsgTemplate('activation');
				$mailer->setMsgBody(array('User_Real_Name_To_Be_Done_Add_Profile_Table',array('<a href="http://localhost'.Yii::app()->createUrl('/user/libuser/activate',array('aid' => $aid )).'">http://localhost'.Yii::app()->createUrl('/user/libuser/activate',array('aid' => $aid )).'</a>')));
				$mailer->doSendMail();
			}

			//create default profile
			$cprofile = new Profile;
			$cprofile->uid = $insertedUser->id;
			$cprofile->avatar = 'default_avatar.jpg';
			$cprofile->real_name = 'NOT_DONE_AT_REGISTER_FORM';
			$cprofile->description = '这个人很懒，什么都没写';
			$cprofile->save();
		}
		return parent::afterSave();
	}

}