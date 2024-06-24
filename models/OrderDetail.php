<?php

class OrderDetail extends BaseModel {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{order_detail}}';
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
            'order_id' => '订单编号',
            'food_id' => '菜品编号',
            'number' => '购买数量',
            'remark' => '客户备注',
            'status' => '订单状态'
        );
    }

    public function attributeRule()
    {
        return array(
            array('order_id,food_id,number,remark,status', 'required'),
            array('order_id,food_id,number,remark,status', 'safe'),
            array('number', "numerical", "integerOnly" => true),
        );
    }


}
