<?php

class testVenue extends BaseModel {
    public function tableName() {
        return '{{test_venue}}';
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
        'id'=>'内部id',
        'comCode' =>'社区编号',
        'comName' =>'社区名称',
        'staCode' =>'场馆编号',
        'staName' =>'场馆名称',
        'code' =>'场地编号',
        'name' =>'场地名称',
        'proCode' =>'开设项目编号',
        'project' =>'开设项目',
        'serType' =>'开设服务',
        'capacity' =>'容纳人数',
        'group_type' =>'场地类型',
        'audState' =>'审核状态',
        'reviewCom' =>'审核意见',
      //  'price_detail_id'=>'对应商品'
        'product_id' => '商品id',//mall_product表的关联
        'product_code'=>'商品编号',//关联mall_product表的product_code字段',
        'product_name' => '商品名称',
       );
    }

    public function getrelations() {
      $s1='testStadium,staCode:code,staCode:code&comName&comCode&';
      $s1.='staName:name;';
      $s1.='ProjectList,project:project_name,proCode:CODE;';
      $s1.='MallProducts,product_id:id,product_code,product_name:name';
      return $s1;
    }

    protected function afterFind(){
        parent::afterFind();
        return true;
    }

    protected function beforeSave() {
        parent::beforeSave();
        if(is_array($this->serType)) $this->serType = implode(",",$this->serType);
        return true;
    }

public function keySelect(){
   $w1="audState='审核通过' and comCode='".$_SESSION['club_code']."'";
   return array($w1,'code','id:name');
}
 
 public function selectClub(){
   $w1="audState='审核通过' and comCode='".$_SESSION['club_code']."'";
   return array($w1,'code','id:name');
}
 
   public function getAll($cr='1'){
        return $this->findAll($cr);
    }

//取社区所有的id
 public function getVenueIds($clubcode=''){
    $tmp=$this->getClubVenue($clubcode);
    return readSetstr($tmp,'id','0');
}

 public function getClubVenue($clubcode=''){
    $clubcode=(empty($clubcode)) ? $_SESSION['club_code'] :$clubcode;
    return $this->findAll('comCode="'.$clubcode.'"');
}

  function venlist($stac='b'){
    $w1= 'comCode="'.$_SESSION['club_code'].'"';
    $w1.=' and staCode= "'.$stac.'"';
    $tmp=$this->findAll($w1.' order by code');
    return array($tmp,'id:name');
  }

    // public function picLabels() {
    //     return 'pic';
    // }

    // public function pathLabels(){ 
    //     return 'image/tmp';
    // }

}
