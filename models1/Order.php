<?php

class Order extends BaseModel {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{order}}';
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'mall_product_data' => array(self::BELONGS_TO, 'MallProductData', 'product_data_id'),
        );
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
            'kitchen_id' => '厨房编号',
            //'product_data_id' => '收费项目',
            'customer_id' => '顾客编号',//多长时间切换显示
            'amount' => '总金额',
            'create_time' => '创建时间'
        );
    }

    public function attributeRule()
    {
        return array(
            array('order_id,kitchen_id,customer_id,amount', 'required'),
            array('order_id,kitchen_id,customer_id,amount', 'required'),
            array('order_id', 'required'),
            array('create_time', 'safe'),
        );
    }

}
