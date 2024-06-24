<?php

class testStadiumPolicy extends BaseModel {
    public $up_times='',$sell_times='',$start_days='';
    public function tableName() {
        return '{{test_stadium_policy}}';
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
          'id'=>'编号',
          'stadium_no' =>'放场单号',
          'stadium_id'=>'场馆编号',
          'stadium_name'=>'场馆名称',
          'place_type'=>'场地类型',
          'up_time'=>'上线时间',
          'advance_day'=>'提前订场天',
          'down_time'=>'下线时间',
          'up_times'=>'上线显示时间',
          'line_day'=>'截止天数',
          'sell_time'=>'营业时间',
          'sell_times'=>'销售时间',
          'place'=>'场地',
          'policy_id'=>'价格编码',
          'policy_name'=>'价格名称',
          'start_day'=>'开始日期',
          'end_day'=>'结束日期',
          'start_days'=>'放号日期',
          'clubcode'=> '社区编码',
          'clubname' => '社区名称'
       );
    }

//stadium_no,stadium_name,place,policy_name,
//start_days,up_times,sell_times,clubname
protected function afterFind(){
  parent::afterFind();
  $this->start_days=$this->toStartEnd($this->start_day, $this->end_day);
  $this->up_times=$this->toStartEnd($this->up_time,$this->down_time);
  $this->sell_times=$this->toStartDay($this->sell_times, $this->advance_day);
    return true;
}
//'Y-m-d H:i:s'
function toStartEnd($d1,$d2){
  return $this->dateYmd($d1).'<br>'.$this->dateYmd($d2);
}
    
function toStartDay($d1,$dn){
  return $this->dateYmd($d1).'<br>提前'.$dn.'天';
}

function dateYmd($d1){
  if(is_string($d1)) {
     $d1=trim( $d1);
  } else{
    $d1= (empty($d1)) ? '' : date('Y-m-d',$d1);
  }
  return $d1;
}

protected function beforeSave() {
    parent::beforeSave();
   // $w1="audState='审核通过' and listTime<='".$this->sell_time."'";
   // $w1.=" and delistTime>='".$this->sell_time."'";
   /// $w1.=" and staName='".$this->stadium_name."'";
   // $w1.=" and venName LIKE '%".$this->place."%'";
   // $tmp = testSubsidy::model()->find($w1);
  //  $this->setFromArray($tmp,'subCode:code,subName:name,subPrice:price');
    return true;
    }
    /* 用于列表查询使用，三个参数分别是  1 条件 2 是排序 三是或取值，格式 变量[：变量]*/
    // public function keySelect(){
    //     return array('1=1', 'id', 'name:name');
    // }

}