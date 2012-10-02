<?php

/**
 * This is the model class for table "tbl_problem".
 *
 * The followings are the available columns in table 'tbl_problem':
 * @property integer $id
 * @property integer $course
 * @property integer $type
 * @property string $content
 * @property string $source
 * @property integer $difficulty
 * @property string $create_time
 * @property string $reference_ans
 * @property string $ans_explain
 * @property integer $use_count
 */
class Problem extends CActiveRecord
{
	const SINGLE_CHOICE=0;
	const MULTIPLE_CHOICE=1;
	const BLANK=2;
	const QuAn=3;

	const A=0;
	const B=1;
	const C=2;
	const D=3;
	const E=4;
	
	static public $difficulty_level_map = array(
				0 => "易",
				1 => "较易",
				2 => "中",
				3 => "较难",
				4 => "难",
	);
	static public $problem_type_map = array(
			self::SINGLE_CHOICE=>'单项选择',
			self::MULTIPLE_CHOICE=>'多项选择',
			self::BLANK=>'填空',
			self::QuAn=>'问答',);
	public function getDifficultyLevel()
	{
		return Problem::$difficulty_level_map;
	}

	public function getDifficulty()
	{
		if ( isset($this->difficulty) && isset(Problem::$difficulty_level_map[ $this->difficulty ]) ) {
			return Problem::$difficulty_level_map[ $this->difficulty ];
		}
		else {
			return "未知难度";
		}
	}
	/**
	 * Returns the static model of the specified AR class.
	 * @return Problem the static model class
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
		return 'tbl_problem';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subject', 'required'),
			array('id, subject, type, difficulty, use_count', 'numerical', 'integerOnly'=>true),
			array('source', 'length', 'max'=>255),
			array('content, create_time, reference_ans, ans_explain', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, subject, type, content, source, difficulty, create_time, reference_ans, ans_explain, use_count', 'safe', 'on'=>'search'),
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
				'problem_kp'=>array(self::MANY_MANY , 'KnowledgePoint' , 'tbl_problem_kp(problem_id,knowledge_point)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'subject' => 'Subject',
			'type' => 'Type',
			'content' => 'Content',
			'source' => 'Source',
			'difficulty' => 'Difficulty',
			'create_time' => 'Create Time',
			'reference_ans' => 'Reference Ans',
			'ans_explain' => 'Ans Explain',
			'use_count' => 'Use Count',
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
		$criteria->compare('subject',$this->subject);
		$criteria->compare('type',$this->type);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('source',$this->source,true);
		$criteria->compare('difficulty',$this->difficulty);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('reference_ans',$this->reference_ans,true);
		$criteria->compare('ans_explain',$this->ans_explain,true);
		$criteria->compare('use_count',$this->use_count);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	static public function getTypeOptions()
	{
		return Problem::$problem_type_map;
	}
	public function getType()
	{
		if ( isset($this->type) && isset(Problem::$problem_type_map[ $this->type ]) ) {
			return Problem::$problem_type_map[ $this->type ];
		}
		return "未知题目类型";
	}
}