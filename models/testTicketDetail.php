<?php

class testTicketDetail extends BaseModel { 
    public function tableName() {
        return '{{test_ticket_detail}}';//'场馆定场及使用明细表'; 
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
    /* 
     来源 'test_stadium_no' => 'NO',//test_stadium_policy 的
     或mall_price_set 上架
    */
  
    public function attributeSets() {
        return array(
      'id' =>'id',
      'set_id'=>'上架单ID',
      'test_stadium_no' => 'NO',//test_stadium_policy 的
      'test_order' =>'序号',
      'test_title'=> '放票项目名',
      'tickettype' => '放票类型',// 1 场馆  2 门票
      'ticketname' => '票类名称',
      'ptype'=>'场地类型',
      'ptypename'=> '场地类型',
      'stadium_policy_id' => '场地策略',//id
      'stadium_id' => '场馆编码',
      'stadium_name' => '场馆名称',
      'place_id' => '场地编码',
      'place_name' => '场地名称',
      'project' => '运动项目',
      'price_info_id'=> '价格明细ID',//来源 test_prinfo
      'price_info_name'=>'价格名称',// 来源test_price_info
      'price_policy_id' >'价格段ID',//来源test_price_policy id
      'sell_time' => '营业时间',
      'week'=> '星期',
      'timespace' => '时间段',
      'price' => '价格',
      'limit_time' => '解锁时间',
      'on_time' => '上线时间',
      'down_time' => '下线时间',
      'order_no' => '订单号',
      'booker' => '订场人',
      'book_time' => '订场时间',
      'payment_type' => '付款类型',//，微信，支付宝等
      'payment_no' => '付款单号',
      'payment_price' => '付款金额',
      'is_lock' => '场馆锁定',
      'lock_time' => '锁定时间',
      'status' => '场馆状态',//（0可用，1已出售，2锁场）
      'lockstart' => '开始锁定',
      'lockend' => '锁定结束',
      'lockuserid' => '锁定',//0 否  1 是
      'lockusername' => '锁定人',
      'lockdate' => '锁定日期',
      'checkuserid' => '订单审核人',
      'checkusername' => '订单审核人',
      'clubid'=>'社区ID',
      'clubcode' => '社区编码',
      'clubname' => '社区名称',
      'checkin' => '已经使用',//是否 0 否 1 使用
      'checkintime' => '使用时间',
      'checkcode' => '扫描二维码'
       );
    }
 
    protected function afterFind(){
        parent::afterFind();
        return true;
    }
    protected function beforeSave() {
        parent::beforeSave();
        return true;
    }

  function subDays($start, $days) {
      $new_date = date_sub($start, new DateInterval("P{$days}D"));
      return date_format($new_date, 'Y-m-d');
  }

  public function getNewDate($cdate,$adays){
      $res=$this->dateCreate($cdate);
      return $this->subDays($res,$adays);
  }

 public function dateCreate($cdate){
      $res=date_format($cdate, 'Y-m-d');
      return date_create($res);
  }

   
/*
不同日期，场地价格设置
*/
public function setDetail($model){
  $current_date = date_create($model->start_day);
  $end_date = date_create($model->end_day);
  $aday=$model->advance_day;
  $lday=$model->line_day;
  $s1='stadium_policy_id:id,stadium_id,stadium_name,is_lock=0,status=0';
  $tmp=new testTicketDetail;
  $tmp->setFromArray($model,$s1);
  while ($current_date <= $end_date) {
      $tmp->on_time=$this->getNewDate($current_date,$aday);
      $tmp->down_time=$this->getNewDate($current_date,$lday);
      $sell_time=date_format($this->dateCreate($current_date),'Y-m-d');
      $tmp->sell_time=$sell_time;
      $this->setPlace($tmp, $model);//每一天的价格设置
      date_add($current_date, new DateInterval('P1D'));
    }
  } 

/*不同场地相同星期的价格设置，每一天不同场地价格设置*/

function setPlace($tmp,$model){
    $week=toCWeek(date('l', strtotime($tmp->sell_time)));
    $ptype=$model->place_type;
    $price_w='stadium_policy_id='.$model->policy_id.' and place_type="';
    $price_w.=$ptype.'" and week="'.$week.'"';
    //$prices=testPricePolicy::model()->findAll($w1.'week="'.$week.'"');
    $w1='staName="'.$model->stadium_name.'" and group_type="'.$ptype.'"';
    $w1.=' and name="';
    $placeList=explode(',',$model->place);
    foreach($placeList as $p){
       $p_id=testVenue::model()->readValue($w1.$p.'"','id');
       $tmp->place_id=$p_id;
       $tmp->place_name=$p;
       $this->saveDetail($tmp,$price_w);
    }
  } 
 

/*$tmp某一场地，相同价格类型，不同时间段的价格
prices='time'  '时间段', 'price'  '时间段价格',
  'week' varchar(20) DEFAULT '' COMMENT '星期',
*/
function saveDetail($tmp,$price_w){
   $prices=testPricePolicy::model()->findAll($price_w);
   foreach($prices as $v){ 
      $tm=new testTicketDetail;
      $tm->attributes=$tmp->attributes;
      $tm->setFromArray($v,'timespace:time,price');
      $tm->save();
    }
  }
/*
不同日期，场地价格设置
 'start_sale_time' => '销售时间:k',
      clubcode' => '社区编码',
      'clubname' => '社区名称',
        'down_time' => '销售结束:k',
*/
       
public function mallsetDetail($set_id){
  //$tmp0=MallPriceSet::model()->find('id='.$set_id);
  $tmpA=MallPriceSetDetails::model()->findAll('set_id='.$set_id);
  $s1='stadium_policy_id:id,is_lock=0,status=0,stadium_id,';
  $s1.='stadium_name:service_stadium,ptypename:service_group,';
  $s1.='clubcode:supplier_code,clubname:supplier_name,clubid:';
  $s1.='supplier_id,place_id:service_id,place_name:service_name';
  $s1.=',set_id,price_info_id:service_data_id,price_info_name';
  $s1.=':service_data_name,test_stadium_no:set_code,test_title';
  $s1.=':event_name,tickettype:pricing_type,';
  $s1.='ticketname:pricing_type_name';
  $tmp=new testTicketDetail;
  foreach ($tmpA as $key => $tmp0) { //场地
      $c_date = date_create($tmp0->start_sale_time);
      $end_date = date_create($tmp0->down_time);
      $aday=$tmp0->advance_day;
      $lday=$tmp0->line_day;
      $xh=0;
      $tmp->setFromArray($tmp0,$s1);//初始化不同场地
      while ($c_date <= $end_date) { 
          $tmp->on_time=$this->getNewDate($c_date,$aday);
          $tmp->down_time=$this->getNewDate($c_date,$lday);
          $stime=date_format($this->dateCreate($c_date),'Y-m-d');
          $tmp->sell_time=$stime; //初始化一天的数据
          $this->mallsetPlace($tmp,$xh);//每一天的价格设置
          date_add($c_date, new DateInterval('P1D'));
        }
     }
  }


function mallsetPlace($tmp,&$xh){
    $tmp->week=toCWeek($tmp->sell_time);//日期转换星期
    $w0=' place_type="'.$tmp->ptypename.'"';
    $w0.=' and week="'.$tmp->week.'" ';
    $w0.=' and info_id='.$tmp->price_info_id;
    //获取 场馆对应类型每天不同时间段的价格
    $prices=testPricePolicy::model()->findAll($w0);
    $w0=' ptypename="'.$tmp->ptypename.'"';
    $w0.=' and sell_time="'.$tmp->sell_time.'" ';
    $w0.=' and place_id="'.$tmp->place_id.'"';
    $w0.=' and price_info_id='.$tmp->price_info_id;
    $fs='timespace:time,price,price_policy_id:id';
    foreach($prices as $v){ 
        $w1=$w0.' and price_policy_id='.$v->id;
       // $w1.=' and sell_time="'.$tmp->sell_time.'" ';
        $tm= testTicketDetail::model()->find($w1);
        if(empty($tm)){
          $tm=new testTicketDetail;
        }
        $tmp->id=$tm->id;     
        $tm->attributes=$tmp->attributes;
        $xh=$xh+1;
        $tm->test_order=$xh;
        $tm->setFromArray($v,$fs);
        $tm->save();
        
      }
  }
  //数组中的一个元素包含了一个时段从运营时间到结束时间的全部内容
  //poid用于确定一天的时间按照什么样子的策略进行分段
  public function getPrices($id,$poid,$services='普通场地'){
    $sers=explode(',',$services);//默认查找普通场地
    $ds=array();
    foreach($sers as $v){
      $ds[]=array($v,$this->getServicePrices($id,$poid,$v));
    }
   return $ds;
 }
/* 每中服务不同层次的价格，$sername 层次
*/
 public function getServicePrices($id,$poid,$sername){
    $i=1;
    $ds=array();
    $w1='policy_id='.$poid.' order by id';//获取到对应策略的所有时间分段
    $timespace=testTimeSpace::model()->findAll($w1);
    $w1='set_id='.$id.' and ptypename="'.$sername.'"';
    $place_id = testTicketDetail::model()->find($w1.' order by timespace');
    $place_id=$place_id->place_id;
/*    put_msg('测试place_id');
    put_msg($place_id);*/
    $tmp=testTicketDetail::model()->findAll($w1.'and place_id='.$place_id.' order by timespace');
    foreach($timespace as $eachspace){
       $tm=$eachspace->time;
       $ds0=array();
       $ds0[]=$tm;
      foreach($tmp as $each){//每一个时间段比较
         if($each->timespace==$tm){
           $ds0[]=$each->price;
         }
      }
      $ds[]=$ds0;
    }
   return $ds;
}

}