<?php

class MallPriceSet extends BaseModel {
	public $product = '';
	public $pricing = '';
	public $post_list = '';
	public $flash_s = '';
  public $testVenue ='',$stadium='',$advance_stop='';
  public $opt0,$opt1,$opt2,$opt3,$opt4,$opt5,$opt6,$opt7,$opt8;
  public $star_times,$start_sales;

  public function tableName() {
        return '{{mall_price_set}}';
    }

      /**
     * 模型关联规则
     */
    public function relations() {
        return array(
        'mall_price_set_details' => array(self::HAS_MANY, 'MallPriceSetDetails', array('id' => 'set_id')),
        'base_code' => array(self::BELONGS_TO, 'BaseCode', 'f_check'),
        'pricingtype' => array(self::BELONGS_TO, 'BaseCode', 'pricing_type'),
        'club_list' => array(self::BELONGS_TO, 'ClubList', 'supplier_id'),
        'member_price' => array(self::BELONGS_TO, 'MallMemberPriceInfo', 'mall_member_price_id'),
        'salesperson_profit' => array(self::BELONGS_TO, 'GfSalespersonInfo', 'salesperson_profit_id'),
        'admin_frozen_id' => array(self::BELONGS_TO, 'QmddAdministrators','frozen_id'),
        );
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
        'id' =>'ID',
        'event_code' =>'方案编号',
        'event_title' => '方案标题:k',
        'supplier_id' =>'销售商家:k',
        'supplier_name' =>'供应商名称',
        'if_user_state' => '上线状态', //0 否 1 是
        'user_state_name' => '上线状态',
        'pricing_type' => '订单类型',
        'pricing_type_name' => '订单类型',
        'flash_sale' => '显示限时抢购',
        'star_time' => '上线时间:k',
        'start_sale_time' => '销售时间:k',
        'end_time' => '下线时间:k',
        'down_time' => '下架时间:k',
        'advance_day'=>'销售提前天数',
        'line_day'=>  '提前停止销售',
        'memo'=>'备注说明',
        'mall_member_price_id' => '定价方案:k',
        'mall_member_price_name' => '定价方案',  // 销售成员价格方案名称，来源mall_member_price_info 名称
        'add_adminid' => '添加管理员',
        'update_date' => '操作时间',
        'f_check' => '审核状态',
        'f_check_name' => '审核状态',
        'reasons_adminID' => '操作员',
        'reasons_admin_nick' => '操作员名称',
        'reasons_for_failure' => '审核说明',
        'reasons_time' => '审核时间',
        'data_sourcer_table' => '上架关联表',
        'data_sourcer_id' => '数据来源表ID',  // ID=0 表示全部',
        'data_sourcer_name' => '数据来源名称',  // 例如比赛名称等',
        'data_sourcer_bz' => '备注说明',
        'if_del' => '逻辑删除',
        'down_up' => '上下架类型', //1上架-1下架在BASECODE ID=21，22的BASECODE',
        'service_id' => '服务产品id',  // 根据pricing_type类型取表ID,详细数据可查看base_code表'
        'frozen_id' => '冻结人',
        'frozen_time' => '冻结时间',
        'apply_time' => '申请时间',
        'star_time1' => '开始使用',
        'end_time1' => '结束使用',
        'supplier_name1' => '使用方案单位',
        'product_name' => '绑定商品名称',
        'product_code' => '绑定商品编号',
        'salesperson_profit_id' => '毛利分配',
        'salesperson_profit_name' => '毛利分配', 
        'testVenue'=>'场地',
        'star_times'=>'上线时间',
        'start_sales'=>'运营时间',
        //场地集合
        // 商品毛利分配方案名称,对应gf_salesperson_info NAME
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
    $this->star_times=$this->star_time.'<br>'.$this->end_time;
    $this->start_sales=$this->start_sale_time.'<br>'.$this->down_time;
    $this->advance_stop=$this->advance_day.'/'.$this->line_day;
    return true;
}

public function updateCheckMsg() {
      $this->reasons_adminID = Yii::app()->session['admin_id'];
      $this->reasons_admin_nick = Yii::app()->session['gfnick'];
      $this->reasons_time = date('Y-m-d H:i:s');
      return true;
  }

protected function beforeSave() {
    parent::beforeSave();
    return true;
}
public function putStateTo(){
  if(!empty($this->id)){
    $w1='set_id='.$this->id;
    $sta=array('f_check'=>$this->f_check);
    $sta['f_check_name']=$this->f_check_name;
    MallPriceSetDetails::model()->updateAll($sta,$w1);
  }
//    MallPriceSetDetails::model()->saveDetails($model->id,$post); 
 }
public function initdata() {
      if(mb_strlen($this->event_code)<5){
        $this->event_code=getAutoNo('mall_price_set');
       }
       if(empty($this->supplier_name)){
         $this->supplier_id=$_SESSION['club_id'];
         $this->supplier_name=$_SESSION['club_name'];
       }
      
    }
  /*
   设置订单类型，1 订场费，2 门票。。。
   */
 public function setOrderType($ptype='',$pname='') {
   if(!empty($ptype)&&(empty($this->pricing_type_name) ) ) {
    $this->pricing_type=$ptype;
    $this->pricing_type_name=$pname;
   }
  }

public function pricePlan($pmode='testPriceinfo',$id='id',$pname='name') {
    $w1=$id.'='.$this->mall_member_price_id;
    $rs=$pmode::model()->readValue($w1,$pname);
    $this->mall_member_price_name=$rs;
  }

public function getrelations() {
  $s1='ClubList,supplier_id:id,supplier_code:club_code';
  $s1.='&supplier_name:club_name';
  return $s1;
}

    function updatePriceSet($tmp0,$id,$typeid,$datastr){
        //*定价方案开始*/
        $w1='service_id='.$id.' and pricing_type='.$typeid;
        $tmp= MallPriceSet::model()->find($w1);
        if(empty($tmp)){
           $tmp = new MallPriceSet;
           $tmp->isNewRecord = true;
            unset($tmp->id);
        }
        $tmp->setFromArray($tm0,$datastr);
        $tmp->save();
    }
  public function getVenueIds(){
        $set_id=($this->id) ? $this->id :0 ;
        //*定价方案开始*/
        $ids=testVenue::model()->getVenueIds();
        $w1='set_id='.$set_id.' and service_id in ('.$ids.')';
        $tmp=MallPriceSetDetails::model()->findAll('set_id='.$set_id);
        $rs=readSetstr($tmp,'service_id','0',1);//活动数组
        return  $rs;
    }
 
}
