<?php

class MealType extends BaseModel {
    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return '{{meal_type}}';
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array();
    }

     public function rules() {
      return $this->attributeRule();
    }
    /** * 属性标签 */
    public function attributeLabels() {
        return $this->getAttributeSet();
    }
    public function attributeSets() {
        return array(
	    'id' =>'ID:k',
        'meal_type' => '宴席类型:k'
        );
    }

}