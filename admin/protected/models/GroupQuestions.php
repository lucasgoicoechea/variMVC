<?php
class GroupQuestions extends CActiveRecord {
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function tableName() {
		return 'group_questions';
	}
	public function rules() {
		return array (
				array (
						'descripcion',
						'length',
						'max' => 150 
				),
				array (
						'color',
						'length',
						'max' => 10 
				),
				array (
						'id, descripcion, color',
						'safe',
						'on' => 'search' 
				) 
		);
	}
	public function relations() {
		return array ();
	}
	public function behaviors() {
		return array (
				'CAdvancedArBehavior',
				array (
						'class' => 'ext.CAdvancedArBehavior' 
				) 
		);
	}
	public function attributeLabels() {
		return array (
				'id' => Yii::t ( 'app', 'ID' ),
				'descripcion' => Yii::t ( 'app', 'Descripcion' ),
				'color' => Yii::t ( 'app', 'Color' ) 
		);
	}
	public function search() {
		$criteria = new CDbCriteria ();
		
		$criteria->compare ( 'id', $this->id, true );
		
		$criteria->compare ( 'descripcion', $this->descripcion, true );
		
		$criteria->compare ( 'color', $this->color, true );
		
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria 
		) );
	}
}
