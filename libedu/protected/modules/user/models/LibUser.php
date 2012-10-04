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
	public $oldpassword = null;


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
	/*
	 * 判断当前用户是否老师
	 */
	public static function is_teacher()
	{
		return Yii::app()->user->urole == Yii::app()->params['user_role_teacher'];		
	}
	public static function is_student()
	{
		return Yii::app()->user->urole == Yii::app()->params['user_role_student'];
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
			'user_course'=>array(self::MANY_MANY,'Course','tbl_user_course(user_id,course_id)'),
			'teacher_class'=>array(self::MANY_MANY,'LibClass','tbl_user_class(teacher_id,class_id)'),
			'unique_id'=>array(self::HAS_MANY,'UserSchool','user_id'),
			'trace_item'=>array(self::MANY_MANY,'Item','tbl_teacher_item_trace(teacher,item)'),
			'task_as_student'=>array(self::MANY_MANY,'Task','tbl_task_record(accepter,task)'),
			'task_as_teacher'=>array(self::HAS_MANY , 'Task','author'),
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
			'oldpassword'=>'旧密码',
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
		if($this->realname != 'testa'){
			$ua = new UserActive;
			$res = $ua->findByAttributes(array('school_id'=>Yii::app()->params['currentSchoolID'],'school_unique_id'=>$this->schooluniqueid,'class_id'=>$this->classid,'name'=>$this->realname));
			if(!$res){
				if($attribute=='classid'){
					$this->addError($attribute,'您的信息不在本系统内，请重新确认您的真实姓名，学号和班级选择是否正确或咨询您的班主任以获取正确的信息。');
				}
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

	public function validateLecActivationCode($aid){
		$usractive = new UserActive;
		$res = $usractive->findByAttributes(array('active_id' => $aid ));
		if(!$res){
			return false;
		}else{
			return true;
		}
	}

	public function validateResetPassword($aid,$uid){
		$res = TempActive::model()->findByAttributes(array('active_id'=>$aid,'user_id'=>$uid));
		if(!$res){
			return false;
		}else{
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

	public function sendResetPasswordEmail($uemail){
		$res = $this->findByAttributes(array('email' => $uemail));
		if(!$res){
			return false;
		}else{
			$aid = md5($res->user_profile->real_name.$res->email.Yii::app()->params['currentSchoolID'].time());

			$mailer = new Emailer($uemail, $res->user_profile->real_name);
			$mailer->setMsgSubject('LibSchool帐号 - 重置密码');
			$mailer->setMsgTemplate('resetpassword');
			$mailer->setMsgBody(array($res->user_profile->real_name,array('<a href="http://localhost'.Yii::app()->createUrl('/user/libuser/resetpassword',array('aid' => $aid, 'uid'=>$res->id )).'">http://localhost'.Yii::app()->createUrl('/user/libuser/resetpassword',array('aid' => $aid , 'uid'=> $res->id )).'</a>')));
			$mailer->doSendMail();

			$tac = new TempActive;
			$tac->user_id = $res->id;
			$tac->type = 1;
			$tac->active_id = $aid;
			$tac->create_time = date("Y-m-d H:i:s");
			$tac->save(false);
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
		if(($this->oldpassword == 'lectureractivation')||($this->oldpassword == 'addadmin')){
			$this->status = 2;
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

	public function validateTeacherFromArray($stuinfo = null,$schoolid){
		if(!$stuinfo){
			return null;
		}
		$result = array();
		$ttl = -1;
		foreach($stuinfo as $singlestu){
			$usc = new UserSchool;
			$cres = $usc->findByAttributes(array('school_id'=>$schoolid,'school_unique_id'=>$singlestu['邮箱']));
			$ttl ++;
			$result[$ttl] = $singlestu;
			// check if the record is a replica
			$result[$ttl]['failreason'] = '';
			if(!$cres){
				$ua = UserActive::model()->findByAttributes(array('school_unique_id'=>$singlestu['邮箱'],'school_id'=>Yii::app()->params['currentSchoolID'],'name'=>$singlestu['姓名']));
				if($ua){
					$result[$ttl]['failreason'] .= '该教师在系统中已存在 ';
				}				
			}else{
				$result[$ttl]['failreason'] = '该教师已经是本校的教师';
			}
		}
		return $result;
	}

	public function addTeacherFromArray($stuinfo = null,$schoolid){
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
			$cres = $usc->findByAttributes(array('school_id'=>$schoolid,'school_unique_id'=>$singlestu['邮箱']));
			
			$ua = UserActive::model()->findByAttributes(array('school_id'=>$schoolid,'school_unique_id'=>$singlestu['邮箱']));
			$uaa = $this->findByAttributes(array('email'=>$singlestu['邮箱']));
				
			// check if the record is a replica
			
			/*if((!$cres)&&(($uaa)||($ua))){
				//notification
				//accept add
				//decline add
			}*/

			if((!$cres)&&(!$ua)&&(!$uaa)){

				//create user active record;
				$ua = new UserActive;
				$ua->school_id = $schoolid;
				$ua->school_unique_id = $singlestu['邮箱'];
				$ua->name = $singlestu['姓名'];		
				$aid = md5($singlestu['姓名'].$singlestu['邮箱'].$schoolid.time());
				$ua->active_id = $aid;
				$ua->create_time = date('Y-m-d H:i:s');

				if($ua->save()){
					//send activation email

					$mailer = new Emailer($singlestu['邮箱'],$singlestu['姓名']);
					$mailer->setMsgSubject('激活您的LibSchool帐号');
					$mailer->setMsgTemplate('activation');
					$mailer->setMsgBody(array($singlestu['姓名'],array('<a href="http://localhost'.Yii::app()->createUrl('/user/libuser/lecactivate',array('aid' => $aid , 'sid'=> $singlestu['邮箱'], 'schid'=>Yii::app()->params['currentSchoolID'])).'">http://localhost'.Yii::app()->createUrl('/user/libuser/lecactivate',array('aid' => $aid)).'</a>')));
					$mailer->doSendMail();
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

	public function addUserFromArray($stuinfo = null,$schoolid){
		$result = array('status'=>0,'total'=>0,'success'=>0,'fail'=>0,'addedstuinfo'=>array());
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

				$aid = md5($singlestu['姓名'].$singlestu['学号'].$schoolid.time());
				$ua->active_id = $aid;
				$ua->create_time = date('Y-m-d H:i:s');

				if($ua->save()){
					$ttlRec ++;
					$secRec ++;	
					$result['addedstuinfo'][$secRec] = $singlestu;
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
			if(($this->oldpassword!='lectureractivation')&&($this->oldpassword!='addadmin')){
				$usractive = new UserActive;
				$res = $usractive->findByAttributes(array('school_unique_id'=>$this->schooluniqueid,'name'=>$this->realname));
				$aid = $res->active_id;
				//send activation email

				
				$mailer = new Emailer($this->email,$this->realname);
				$mailer->setMsgSubject('激活您的LibSchool帐号');
				$mailer->setMsgTemplate('activation');
				$mailer->setMsgBody(array($this->realname,array('<a href="http://localhost'.Yii::app()->createUrl('/user/libuser/activate',array('aid' => $aid , 'sid'=> $this->schooluniqueid, 'schid'=>Yii::app()->params['currentSchoolID'])).'">http://localhost'.Yii::app()->createUrl('/user/libuser/activate',array('aid' => $aid , 'uid'=> $this->id)).'</a>')));
				$mailer->doSendMail();
			}


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
			$cus->join_time = date("Y-m-d H:i:s");
			if($this->oldpassword=='lectureractivation'){
				$cus->role = 2;		
			}else if($this->oldpassword=='addadmin'){
				$cus->role = 0;
			}else{
				$cus->role = 1;
			}
			$cus->save();			

			if(($this->oldpassword!='lectureractivation')&&($this->oldpassword!='addadmin')){
				//create user class relation
				$cuc = new LibUserClass;
				$ccls = new LibClass;
				$cres = $ccls->findByPk($this->classid);
				$cuc->class_id = $this->classid;
				$cuc->student_id = $this->id;
				$cuc->teacher_id = $cres->classhead_id;
				$cuc->save();
			}
		}

		return parent::afterSave();
	}

}