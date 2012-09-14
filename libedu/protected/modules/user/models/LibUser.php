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
	public $schooluniqueid = null;
	public $realname = null;
	public $classid = null;


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
			array('email, password,repeatpassword, schooluniqueid, classid, realname', 'required'),
			array('mobile', 'unique'),
			array('email','unique','message'=>'您的Email地址已经在系统中存在，如果您在您以前的学校有LibEdu提供支持系统的帐号，请您直接用您以前的帐号登录，如果您不想用以前的帐号，请输入您其他的Email地址。'),
			array('schooluniqueid,classid,realname','validateStudentWithDB'),
			array('email', 'email'),
			array('mobile','match', 'pattern'=>'/^(1(([35][0-9])|(47)|[8][01236789]))\d{8}$/'),
			array('user_name, mobile, email, password', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, mobile, email', 'safe', 'on'=>'search'),
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
			'user_profile'=>array(self::HAS_ONE,'Profile','uid'),
			'school_info'=>array(self::MANY_MANY,'School','tbl_user_school(user_id,school_id)'),
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
			'repeatpassword'=>'密码确认',
			'schooluniqueid'=>'学号',
			'realname'=>'真实姓名',
			'classid'=>'班级',
			'status'=>'状态',
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

	public function validateStudentWithDB($attribute,$params){
		$ua = new UserActive;
		$res = $ua->findByAttributes(array('school_id'=>Yii::app()->params['currentSchoolID'],'school_unique_id'=>$this->schooluniqueid,'class_id'=>$this->classid,'name'=>$this->realname));
		if(!$res){
			if($attribute=='classid'){
				$this->addError($attribute,'您的信息不在本系统内，请重新确认您的真实姓名，学号和班级选择是否正确或咨询您的班主任以获取正确的信息。');
			}
		}
	}

	public function validatePassword($password,$salt){
		return $this->hashPassword($password,$salt)===$this->password;
	}
	
	public function hashPassword($password,$salt){
		return md5($password.$salt);
	}

	public function validateActivationCode($aid,$uid){
		$usractive = new UserActive;
		$res = $usractive->findByAttributes(array('active_id' => $aid ));
		if(!$res){
			return false;
		}else{
			$cusr = $this->findByPk($uid);
			if($cusr->email == Yii::app()->user->name){
				$cusr->status = 2;
				$cusr->save(false);
				$usractive->deleteAllByAttributes(array('active_id'=>$aid));
				return true;
			}else{
				return false;
			}
		}
	}

	public function resendActivationCode($uemail){
		$res = $this->findByAttributes(array('email' => $uemail));
		if(!$res){
			return false;
		} else if($res->status != 1){
			return false;
		}else{
			$aid = md5($res->email.$res->mobile.time());

			$mailer = new Emailer($uemail,'User_Real_Name_To_Be_Done_Add_Profile_Table');
			$mailer->setMsgSubject('激活您的LibSchool帐号');
			$mailer->setMsgTemplate('activation');
			$mailer->setMsgBody(array('User_Real_Name_To_Be_Done_Add_Profile_Table',array('<a href="http://localhost'.Yii::app()->createUrl('/user/libuser/activate',array('aid' => $aid, 'uid'=>$res->id )).'">http://localhost'.Yii::app()->createUrl('/user/libuser/activate',array('aid' => $aid , 'uid'=> $res->id )).'</a>')));
			$mailer->doSendMail();
			$usc = UserSchool::model()->findByAttributes(array('user_id'=>$res->id,'school_id'=>Yii::app()->params['currentSchoolID']));
			$ua = new UserActive;
			$res1 = $ua->findByAttributes(array('school_unique_id'=>$usc->school_unique_id,'name'=>$res->user_profile->real_name));
			$res1->active_id = $aid;
			$res1->create_time = date('Y-m-d H:i:s');
			$res1->save();
			return true;
		}
	}


	public function beforeSave(){
		if ($this->isNewRecord){
			$this->user_name = uniqid();
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
			$result[$ttl]['failreason'] = '';
			if(!$cres){
				$ua = UserActive::model()->findByAttributes(array('school_unique_id'=>$singlestu['学号'],'school_id'=>Yii::app()->params['currentSchoolID']));
				if($ua){
					$result[$ttl]['failreason'] .= '该学生在系统中已存在 ';
				}				
				$cls = new LibClass;
				$ccls = $cls->findByPk($singlestu['班级ID']);
				if(!$ccls){
					$result[$ttl]['filreason'] .= '该学生所在班级不存在，请先建立班级';	
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
			
			$ua = UserActive::model()->findByAttributes(array('school_id'=>$schoolid,'school_unique_id'=>$singlestu['学号']));
			// check if the record is a replica
			if((!$cres)&&(!$ua)){

				//create user active record;
				$ua = new UserActive;
				$ua->school_id = $schoolid;
				$ua->school_unique_id = $singlestu['学号'];
				$ua->class_id = $singlestu['班级ID'];
				$ua->name = $singlestu['姓名'];

				//get grade id
				$grd = new Grade;
				$gid = $grd->findByAttributes(array('grade_name' => $singlestu['年级']));
				$ua->grade = $gid->grade_index;

				$ua->active_id = md5($singlestu['姓名'].$singlestu['学号'].$schoolid.time());
				$ua->create_time = date('Y-m-d H:i:s');

				if($ua->save()){
					$ttlRec ++;
					$secRec ++;	
				}else{
					$ttlRec ++;
					$failRec ++;
				}
			
			}else{ //user school relation exist in this school
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
			
			$usractive = new UserActive;
			$res = $usractive->findByAttributes(array('school_unique_id'=>$this->schooluniqueid,'name'=>$this->realname));
			$aid = $res->active_id;
			//send activation email

			
			$mailer = new Emailer($this->email,$this->realname);
			$mailer->setMsgSubject('激活您的LibSchool帐号');
			$mailer->setMsgTemplate('activation');
			$mailer->setMsgBody(array($this->realname,array('<a href="http://localhost'.Yii::app()->createUrl('/user/libuser/activate',array('aid' => $aid , 'sid'=> $this->schooluniqueid, 'schid'=>Yii::app()->params['currentSchoolID'])).'">http://localhost'.Yii::app()->createUrl('/user/libuser/activate',array('aid' => $aid , 'uid'=> $this->id)).'</a>')));
			$mailer->doSendMail();

			//create default profile
			$cprofile = new Profile;
			$cprofile->uid = $this->id;
			$cprofile->avatar = 'default_avatar.jpg';
			$cprofile->real_name = $this->realname;
			$cprofile->description = '这个人很懒，什么都没写';
			$cprofile->save();

			//create user school relation

			$cus = new UserSchool;
			$cus->user_id = $this->id;
			$cus->school_id = Yii::app()->params['currentSchoolID'];
			$cus->school_unique_id = $this->schooluniqueid;
			$cus->role = 1;
			$cus->save();			

			//create user class relation
			$cuc = new LibUserClass;
			$ccls = new LibClass;
			$cres = $ccls->findByPk($this->classid);
			$cuc->class_id = $this->classid;
			$cuc->student_id = $this->id;
			$cuc->teacher_id = $cres->classhead_id;
			$cuc->save();
		}
		return parent::afterSave();
	}

}