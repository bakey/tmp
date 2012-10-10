<?php

/**
 * This is the model class for table "tbl_multimedia".
 *
 * The followings are the available columns in table 'tbl_multimedia':
 * @property integer $id
 * @property integer $type
 * @property string $name
 * @property integer $uploader
 * @property integer $status
 * @property string $convert_name
 * @property integer $item
 */
class Multimedia extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Multimedia the static model class
	 */
	const TYPE_PPT = 0;
	const STATUS_PROCESSING = 0;
	const STATUS_FINISHED   = 1;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_multimedia';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type,', 'required'),
			array('type, uploader, status, item', 'numerical', 'integerOnly'=>true),
			array(' convert_name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type, uploader, status, convert_name, item', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'type' => 'Type',
			'name' => 'Name',
			'uploader' => 'Uploader',
			'status' => 'Status',
			'convert_name' => 'Convert Name',
			'item' => 'Item',
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
		$criteria->compare('type',$this->type);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('uploader',$this->uploader);
		$criteria->compare('status',$this->status);
		$criteria->compare('convert_name',$this->convert_name,true);
		$criteria->compare('item',$this->item);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}