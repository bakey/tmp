<?php

/**
 * This is the model class for table "tbl_task".
 *
 * The followings are the available columns in table 'tbl_task':
 * @property integer $id
 * @property integer $item
 * @property string $name
 * @property string $create_time
 * @property string $update_time
 * @property string $last_time
 * @property integer $author
 * @property string $description
 * @property integer $status
 */
class Task extends CActiveRecord
{
	const STATUS_DRAFT=0;
	const STATUS_PUBLISHED=1;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Task the static model class
	 */


	public $numberoftaken;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_task';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('item, author, status', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('create_time, update_time, last_time, description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, item, name, create_time, update_time, numberoftaken, last_time, author, description, status', 'safe', 'on'=>'search'),
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
			'problems'=>array(self::MANY_MANY,'Problem','tbl_task_problem(task_id,problem_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'item' => 'Item',
			'name' => '请输入测试名',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'last_time' => 'Last Time',
			'author' => 'Author',
			'description' => '请输入测试的简述',
			'status' => 'Status',
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
		$criteria->compare('item',$this->item);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('last_time',$this->last_time,true);
		$criteria->compare('author',$this->author);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{
				$this->create_time=$this->update_time=date('Y-m-d H:i:s',time());
				$this->author=Yii::app()->user->id;
			}
			else {
				$this->update_time=time();
			}
			return true;
		}
		else {
			return false;
		}
	}

	public function getTypeOptions()
	{
		return array(
			self::STATUS_DRAFT=>'草稿',
			self::STATUS_PUBLISHED=>'发布',
		);
	}
}