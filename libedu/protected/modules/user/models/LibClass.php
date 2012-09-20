<?php

/**
 * This is the model class for table "tbl_class".
 *
 * The followings are the available columns in table 'tbl_class':
 * @property integer $id
 * @property integer $school_id
 * @property string $name
 * @property integer $grade
 * @property integer $classhead_id
 * @property string $description
 */
class LibClass extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LibClass the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_class';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array(' name, grade, classhead_id', 'required'),
			array('school_id, classhead_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, school_id, name, grade, classhead_id, description', 'safe', 'on'=>'search'),
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
			'school_info'=>array(self::BELONGS_TO,'School','school_id'),
			'grade_info'=>array(self::BELONGS_TO,'Grade','grade'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'school_id' => '所属学校',
			'name' => '班级名称',
			'grade' => '年级',
			'classhead_id' => '班主任',
			'description' => '班级描述',
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
		$criteria->compare('school_id',$this->school_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('grade',$this->grade);
		$criteria->compare('classhead_id',$this->classhead_id);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function beforeSave(){
		if($this->isNewRecord){
			$this->school_id = Yii::app()->params['currentSchoolID'];
			$cgrade = Grade::model()->findByAttributes(array('grade_name'=>$this->grade));
			if(!$cgrade){
				throw new CHttpException(403,'您输入的年级不存在');
				exit();
			}else{
				$this->grade = $cgrade->grade_index;
			}
		}
		if($this->classhead_id == -1){
					$this->classhead_id = null;
				}
		return parent::beforeSave();
	}
}