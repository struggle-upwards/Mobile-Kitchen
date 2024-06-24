<?php

class MallPriceSetDetails extends BaseModel {
    public $tmp_no=0,$advance_stop='';
    public function tableName() {
        return '{{mall_price_set_details}}';
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
        'id' => 'ID',
        'set_id' => '策略表id', //,关联mall_price_set表ID',
        'set_code' =>'方案编号',
        'event_name'=>'方案名称',
        'pricing_type' => '订单类型',
        'pricing_type_name' => '订单类型', // -
        // 关联表base_code表order类型ID为351-369明星空间,385、503',
        'no' => '序号',
        'product_id' => '商品id', //关联mall_product表id',
        'product_code' => '商品编号',
        'product_name' => '商品名称',
        'down_pricing_id' => '销售类型',  //关联mall_product_data表ID',
        'json_attr' => '型号/规格',
        'purpose' => '上架来源',  
        'purpose_name' => '上架来源',
        'shop_purpose' => '销售方式',  
        'shop_name' => '购买目的名称',
        'up_quantity' => '上架商品数量',
        'purchase_price' => '采购价',
        'oem_price' => '贴牌价',
        'sale_price' => '商品单价(元)',
        'sale_bean' => '销售豆',
        'sale_price2' => '二次销售价',
        'sale_bean2' => '二次销售豆',
        'post_price' => '运费(元/件)',
        'Inventory_quantity' => '上架数量',
        'secondary_quantity' => '导购',  
        'available_quantity' => '已售数量',  
        'return_quantity' => '退货数量',  
        'change_quantity' => '换货数量', 
        'if_dispay' => '是否下架',  
        'service_id' => '场地id',  
        'service_code' => '场地编码',
        'service_name' => '场地产品',
        'service_group'=>'场地类型',
        'stadium_id'  => '场馆ID',
        'service_stadium' => '场馆名称',
        'service_data_id' => '价格方案ID',
        'service_data_name' => '价格方案名',
        'u_date' => '添加时间',
        'up_price_id' => '上架价格折扣方案', 
        'up_gross_profit_id' => '毛利方案',  //关联mall_gross_profit_id',
        'flash_sale' => '自动上下架表示',
        'star_time' => '上线时间',
        'end_time' => '下线时间',
        'start_sale_time' => '销售时间',
        'down_time' => '销售结束',
        'advance_day'=>'销售提前天数',
        'line_day'=>  '提前停止销售',
        'supplier_id' => '商家名称', 
        'supplier_code' => '商家名称', 
        'supplier_name' => '供应商名称', 
        'sale_id' => '销售方式',
        'up_available_quantity' => '已售数量',
        'f_check' => '审核状态',
        'f_check_name' => '审核状态',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
	protected function afterFind() {
    parent:: afterFind();
    $this->advance_stop=$this->advance_day.'/'.$this->line_day;
    return true;
    }
	protected function beforeSave() {
        parent::beforeSave();
        if($this->isNewRecord){
            $this->u_date = get_date();
        }
        return true;
    }
   //设置自动取数据处理
   public function aagetrelations() {
      $s1='MallPriceSet,set_id:id,comCode&comName&staCode&staName&venCode:code&f_check&f_check_name';
      return $s1;
    } 
   /*
   sid,$did,$parray()=array(array($tmp,field)...)
    */
  public function savePriceDetails($sid,$did,$parray=array()){
    $w1='set_id='.$sid.' and service_data_id='.$did;
    $tmp = MallPriceSetDetails::model()->find($w1);
    if(empty($tmp)){
        $tmp = new MallPriceSetDetails;
        $tmp->isNewRecord = true;
        unset($tmp->id);
    }
    foreach ($parray as  $v ){
      $tmp->setFromArray($v[0],$v[1]);//把($v[0] 按$v[1] 说明赋值到$tmp
    }
    $tmp->save();
   }

    public function getClubAll($w1='1'){
        return testStadium::model()->findAll($w1);
    }
 public function getSetAll($set_id){
        return $this->findAll('set_id='.$set_id);
    }

/*
{"event_title":"啊啊","star_time":"2024-02-23 20:17:40","end_time":"2024-02-23 20:17:42","start_sale_time":"2024-02-23 20:17:44","down_time":"2024-02-23 20:17:47","if_user_state":"649","supplier_id":"2450","mall_member_price_id":"42","opt0":["23","33"],"opt1":["38","40"]}
 */
  public function saveDetails($sid,$post){
    $sa=array();
    $this->tmp_no=0;
    $ch=array('no'=>0);
    MallPriceSetDetails::model()->updateAll($ch,'set_id='.$sid);
    $tmp0= MallPriceSet::model()->find('id='.$sid);
    for($r=0;$r<10;$r++){
        if(isset($post['opt'.$r]) ){
          $sets=$post['opt'.$r];
           if(!empty($sets)) {
             $s1= $this->saveing($tmp0,$sets);
             if(!empty($s1)) $sa[]=$s1;
            }
         }
       }
    $w1='set_id='.$sid.' and no=0';
    MallPriceSetDetails::model()->deleteAll($w1);
    $s1='';
    if(count($sa)>=1)  $s1=$sa[0];
    if(count($sa)>1)  $s1.='等..';
    $tmp0->data_sourcer_name=$s1;
    $tmp0->save();
    testTicketDetail::model()->mallsetDetail($tmp0->id);
 }

 public function saveing($set,$sdata){
    //$set= MallPriceSet::model()->find('id='.$sid);
    $sid=$set->id;
    //从设置单获得数据
    $f1='set_code:event_code,pricing_type_name,supplier_id,';
    $f1.='supplier_name,star_time,end_time,start_sale_time,down_time';
    $f1.=',supplier_code,event_name:event_title,f_check,f_check_name';
    $f1.=',service_data_id:mall_member_price_id,service_data_name:';
    $f1.='mall_member_price_name,advance_day,pricing_type';

     //   'mall_member_price_id' => '定价方案:k',
     //   'mall_member_price_name' => '定价方案',  // 
    // 'service_data_id价格方案ID','service_data_name价格方案名',
    //从场地获得的数据
    $f2='service_id:id,service_code:code,service_name:name,product_id,';
    $f2.='product_code,product_name,up_quantity=1,service_stadium';
    $f2.=':staName,service_group:group_type';
    $stadium='';$cdm='';$r=0;
    foreach($sdata as $v){
        $w1='set_id='.$sid.' and  service_id='.$v;
        $tmp = MallPriceSetDetails::model()->find($w1);
        if(empty($tmp)){
            $tmp = new MallPriceSetDetails;
            $tmp->set_id=$sid;
            $tmp->service_id=$v;
        }
        $tmp->getFrom($set,$f1);//继承单数据
        $tv=testVenue::model()->find('id='.$v);
        $tmp->getFrom($tv,$f2);//获得商品场地信息
        $w1='code="'.$tv->staCode.'"';
        $tmp->stadium_id=testStadium::model()->readvalue($w1,'id');
        if($r<4) $cdm.=$tmp->service_name.','; $r++;
        if(empty($stadium) ) $stadium=$tmp->service_stadium;
        $this->tmp_no=$this->tmp_no+1;
        $tmp->no=$this->tmp_no;
        $tmp->save();
    }
    return $stadium.(empty($stadium) ?'' : ':'.$cdm);
  }
}