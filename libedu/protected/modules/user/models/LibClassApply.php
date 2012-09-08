<?php

/**
 * This is the model class for table "tbl_class_apply".
 *
 * The followings are the available columns in table 'tbl_class_apply':
 * @property integer $applicant
 * @property integer $approver
 * @property integer $class_id
 * @property string $statement
 */
class LibClassApply extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ClassApply the static model class
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
		return 'tbl_class_apply';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('class_id,statement', 'required'),
			array('applicant, approver, class_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('applicant, approver, class_id, statement', 'safe', 'on'=>'search'),
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
			'applicant_info'=>array(self::BELONGS_TO,'LibUser','applicant'),
			'approver_info'=>array(self::BELONGS_TO,'LibUser','approver'),
			'class_info'=>array(self::BELONGS_TO,'LibClass','class_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'applicant' => '申请人',
			'approver' => '批准人',
			'class_id' => '要加入的班级',
			'statement' => '申请附言',
		);
	}

	public function beforeSave(){
		if ($this->isNewRecord){
			$this->applicant = Yii::app()->user->getId();
			$ccls = new LibClass;
			$cls = $ccls->findByPk($this->class_id);
			$this->approver = $cls->classhead_id;
		}
		return parent::beforeSave();
	}

	public function afterSave(){
		return parent::afterSave();
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

		$criteria->compare('applicant',$this->applicant);
		$criteria->compare('approver',$this->approver);
		$criteria->compare('class_id',$this->class_id);
		$criteria->compare('statement',$this->statement,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}