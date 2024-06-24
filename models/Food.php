<?php

class Food extends BaseModel {

    public static function model( $className = __CLASS__ ) {
        return parent::model( $className );
    }

    public function tableName() {
        return '{{food}}';
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
            'id' => 'ID',
            'food_id' => '菜品编号',
            'food_name' => '菜品名称',
            'price' => '菜品价格',
            'count' => '菜品库存',
            'status' => '菜品状态'
        );
    }

    public function attributeRule() {
        return array(
            array( 'food_id', 'required' ),
            array( 'food_id', 'numerical', 'integerOnly' => true ),
            array( 'food_id', 'exist', 'className' => 'Food', 'attributeName' => 'id' ),
            array( 'food_name', 'required' ),
            array( 'food_name', 'length', 'max' => 100 )

        );
    }
}
