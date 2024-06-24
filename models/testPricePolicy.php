<?php

class testPricePolicy extends BaseModel {  
    public function tableName() {
        return '{{test_price_policy}}';
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
     'id'=>'id',
     'info_id'=>'方案ID',
     'clubcode' => '单位编码',
     'clubname' => '单位名称',
     'code'=>'策略编码',
     'name'=>'策略名称',
     'place_type'=>'场地类型',
     'policy_id'=>'时间编号',
     'policy_name'=>'时间名称',
     'time'=>'时间',
     'price'=>'价格',
     'week'=>'星期',
     'f_delete'=>'删除标识'
     );
    }

    //关联数据自动处理
    public function getrelations() {
      $s1='testPriceinfo,info_id:id,clubcode&clubname&code&name';
      $s1.='&policy_id&policy_name&service_type&service_name';
      return $s1;
    }
    protected function afterFind(){
        return true;
    }
    protected function beforeSave() {
        parent::beforeSave();
        return true;
    }

    public function getAll($cr='1'){
        return testPricePolicy::model()->findAll($cr);
    }
    public function setDelete($infoid='0'){
     $rs=array('f_delete'=>-1);
     return testPricePolicy::model()->updateAll($rs,'info_id='.$infoid);
    }
    /* 用于列表查询使用，三个参数分别是  1 条件 2 是排序 三是或取值，格式 变量[：变量]*/
    // public function keySelect(){
    //     return array('1=1', 'id', 'name:name');
    // }
    // 


 public function getPrices($id,$poid,$services='普通场地'){
    $sers=explode(',',$services);
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
    $w1='policy_id='.$poid.' order by id';
    $timespace=testTimeSpace::model()->findAll($w1);
    $w1='info_id='.$id.' and place_type="'.$sername.'"';
    $tmp=testPricePolicy::model()->findAll($w1.' order by time');
    foreach($timespace as $eachspace){
       $tm=$eachspace->time;
       $ds0=array($tm,'','','','','','','');
      foreach($tmp as $each){
         if($each->time==$tm){
           $rs=$this->weekTon($each->week);
           if($rs)  $ds0[$rs]=$each->price;
         }
      }
      $ds[]=$ds0;
    }
   return $ds;
}

 public function setPrices($id,$values){
    $ds=json_decode($values);
    $pcid=testPriceinfo::model()->readValue('id='.$id,'policy_id');
    $tmp0=new testPricePolicy();
    $tmp0->setDelete($id);
    foreach($ds as $v){
      $this->setPriceing($id,$pcid,$v);
    }
    $tmp0->deleteAll('f_delete=-1 and info_id='.$id);
}

//$val[0] 场馆层次 如普通台 等，$val[1]没星期不同时间段价格
function setPriceing($id,$pcid,$val){
  $values=$val[1];
  $ptype=$val[0];
  $week=testWeek::model()->getAll();
  $timespace=testTimeSpace::model()->findAll('policy_id='.$pcid);
  $i=0;  $j=0;$xh=0;
  $s0='info_id='.$id.' and place_type="'.$ptype.'"';
  foreach($timespace as $v){
    $s1=$s0.' and time="'.$v->time.'"';
    foreach($week as $wv){
       $pc=$values[$i][$j];
       if(is_numeric($pc)){
          $w1=$s1.' and week="'.$wv->week.'"';
          $tmp=testPricePolicy::model()->find($w1);
          if(empty($tmp)){
            $tmp=new testPricePolicy;
            $tmp->info_id=$id;
            $tmp->time=$v->time;
            $tmp->week=$wv->week;
          }
          $tmp->place_type=$ptype;
          $xh=$xh+1;
          $tmp->f_delete=$xh;
          $tmp->price=$pc;
          $tmp->save();
        }
        $j++;
    }
   $i++;$j=0;
  }
}

function weekTon($week){
  $rs=0;
  if($week=='星期一') $rs=1;
  if($week=='星期二') $rs=2;
  if($week=='星期三') $rs=3;
  if($week=='星期四') $rs=4;
  if($week=='星期五') $rs=5;
  if($week=='星期六') $rs=6;
  if($week=='星期日') $rs=7;
  return $rs;
}
}