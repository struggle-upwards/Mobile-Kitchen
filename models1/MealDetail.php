<?php

class MealDetail extends BaseModel {
	
    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return '{{meal_detail}}';
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
	    'id' =>'ID',
        'meal_id' => '宴席id',
        'dish_id' => '菜品编码',
        'dish_name' => '菜品名称'
        );
    }

    // public function labelsOfList() {
    //     return array(
    //     'id','order_num','product_code','product_title','json_attr',
    //     'buy_price','buy_count','buy_amount','ret_count','ret_amount',
    //     'supplier_name','order_Date','pay_gfcode',
    //     );
    // }

    // public  function saveOrderdata($order_num){
    //     $tmp = new MallSalesOrderData();
    //     $car=Cardata::model()->findAll('order_num="'.$order_num.'"');
    //     foreach($car as $c) {
    //         $tmp->attributes=$c->attributes;
    //         $tmp->isNewRecord = true;
    //         unset($tmp->id);
    //         //$orderdata->orter_item = 757;
    //         $tmp->save();         
    //         //$orderdata->member_gfid = $c->buy_count;
    //         //$orderdata->storecheck = $c->service_code;
    //     }
    // }
}