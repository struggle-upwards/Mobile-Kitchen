<?php

class swiperImage extends BaseModel {  



    public function tableName() {
        return '{{swiperimage}}';  
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function check_save($show) {
        $this->show=$show;
    }

    public function relations() {
        return array(  );
    }

    public function rules() {
      return array();
    }

    public function attributeLabels() {
        return $this->getAttributeSet();
    }


}
