<?php

/**
 * This is the model class for table "tbl_problem_kp".
 *
 * The followings are the available columns in table 'tbl_problem_kp':
 * @property integer $problem_id
 * @property integer $knowledge_point
 */
class ProblemKp extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProblemKp the static model class
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
		return 'tbl_problem_kp';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('problem_id, knowledge_point', 'required'),
			array('problem_id, knowledge_point', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('problem_id, knowledge_point', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'problem_id' => 'Problem',
			'knowledge_point' => 'Knowledge Point',
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

		$criteria->compare('problem_id',$this->problem_id);
		$criteria->compare('knowledge_point',$this->knowledge_point);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}