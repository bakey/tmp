<?php

/**
 * This is the model class for table "tbl_item".
 *
 * The followings are the available columns in table 'tbl_item':
 * @property integer $id
 * @property string $content
 * @property integer $level
 */
class Item extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Item the static model class
	 */
	public $parent ;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('level', 'numerical', 'integerOnly'=>true),
			array('edi_index' , 'numerical' , 'integerOnly'=>true),
			array('content', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, content, level', 'safe', 'on'=>'search'),
			array('parent' , 'numerical' , 'integerOnly'=>true),
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
				'editions' => array(self::BELONGS_TO , 'CourseEdition' , 'edition'),
				//找到所有本item的儿子item
				'level_child'=>array(self::MANY_MANY , 'Item' , 'tbl_item_item(parent,child)'),
				//找到本item的所有父亲节点
				'level_parent'=>array(self::MANY_MANY , 'Item' , 'tbl_item_item(child,parent)'),
				'relate_kps' => array(self::MANY_MANY , 'KnowledgePoint' , 'tbl_Item_kp(item,knowledge_point)' ),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			//'id' => 'ID',
			'edi_index' => '第几章/第几节',
			'content' => '本章内容',
			'level' => 'Level',
			'parent' => '父章节的id',
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
		$criteria->compare('content',$this->content,true);
		$criteria->compare('level',$this->level);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}