<?php

/**
 * This is the model class for table "com_provincia".
 *
 * The followings are the available columns in table 'com_provincia':
 * @property string $c_id
 * @property string $d_descripcion
 * @property string $c_id_pais
 * @property string $c_codigo
 */
class Provincia extends CActiveRecord {
	/**
	 * Returns the static model of the specified AR class.
	 * 
	 * @param string $className
	 *        	active record class name.
	 * @return Provincia the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	
	/**
	 *
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'com_provincia';
	}
	
	/**
	 *
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array (
				array (
						'd_descripcion',
						'length',
						'max' => 255 
				),
				array (
						'c_id_pais',
						'length',
						'max' => 20 
				),
				array (
						'c_codigo',
						'length',
						'max' => 45 
				),
				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				array (
						'c_id, d_descripcion, c_id_pais, c_codigo',
						'safe',
						'on' => 'search' 
				) 
		);
	}
	
	/**
	 *
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array (
				'pais' => array (
						self::BELONGS_TO,
						'Pais',
						'c_id_pais' 
				) 
		);
	}
	
	/**
	 *
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array (
				'c_id' => 'C',
				'd_descripcion' => 'D Descripcion',
				'c_id_pais' => 'C Id Pais',
				'c_codigo' => 'C Codigo' 
		);
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * 
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria = new CDbCriteria ();
		
		$criteria->compare ( 'c_id', $this->c_id, true );
		$criteria->compare ( 'd_descripcion', $this->d_descripcion, true );
		$criteria->compare ( 'c_id_pais', $this->c_id_pais, true );
		$criteria->compare ( 'c_codigo', $this->c_codigo, true );
		
		return new CActiveDataProvider ( $this, array (
				'criteria' => $criteria 
		) );
	}
}