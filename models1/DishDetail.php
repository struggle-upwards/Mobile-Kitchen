<?php

class DishDetail extends BaseModel {
	
    public function tableName() {
        return '{{dish_detail}}';
    }
    /*** Returns the static model of the specified AR class. */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    /**  * 模型关联规则  */
    public function relations() {
        return array();
    }
    /*** 模型验证规则*/
    public function rules() {
      return $this->attributeRule();
    }
    /** * 属性标签 */
    public function attributeLabels() {
        return $this->getAttributeSet();
    }

    public function attributeSets() {
        return array(
	    'id' =>'菜品编号',
        'kitchen_id' => '厨房id:k',
        'kitchen_code' => '厨房编号',
        'dish_name' => '菜品名称:k',
        'discription' => '菜品描述信息',
        'use_num' => '菜品使用次数',
        'img_url' => '菜品图片'
        );
    }

    public function getwxdishInfo(){//TXADD是头像地址
        $data=baselib::model()->oneToArray($this,'id,kitchen_id:id,dish_name,discription,img_url',array());
        
        if(empty($data['img_url'])) $data['img_url']='/assets/images/dish.bmp';
        return $data;
    }

}