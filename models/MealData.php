<?php

class MealData extends BaseModel {
	// public $pay_supplier_type_name='';
	// public $club_name='';
	// public $order_gfaccount='';
    
    
	
    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return '{{meal_data}}';
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
		//'mall_products' => array(self::BELONGS_TO, 'MallProducts', 'product_id'),
		// 'purpose_B' => array(self::BELONGS_TO, 'BaseCode', 'purpose'),
		// 'store_check' => array(self::BELONGS_TO, 'BaseCode', 'storecheck'),
		// 'order_info' => array(self::BELONGS_TO, 'MallSalesOrderInfo', 'info_id'),
		// 'detail' => array(self::BELONGS_TO, 'MallPriceSetDetails', 'set_detail_id'),
		// 'logistics' => array(self::BELONGS_TO, 'OrderInfoLogistics', 'logistics_id'),
        // 'lowerset' => array(self::BELONGS_TO, 'MallPriceSet', 'down_set_id'),
        // 'type' => array(self::BELONGS_TO, 'BaseCode', 'change_type'),
        // 'gfService' => array(self::BELONGS_TO, 'GfServiceData', 'gf_service_id'),


		);
    }
    public $selectedDishes;

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
        'kitchen_code' => '厨房编号:k',
        'kitchen_name' => '厨房名称:k',
        'meal_code' => '宴席编码',
        'meal_name' => '宴席名称:k',
        'meal_type' => '宴席类型:k',
        'onsale' => '是否上架',
        'price' => '价格（单位：元/桌）:k',
        'description' => '描述信息',
        'f_check' => '审核状态码',
        'f_check_name' => '审核状态',
        'reasons_adminID' => '操作员',
        'reasons_admin_nick' => '操作员名称',
        'reasons_for_failure' => '审核说明',
        'reasons_time' => '审核时间',
        'meal_img_url' => '宴席图片',
        'selected_dishes' => '菜品id',
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