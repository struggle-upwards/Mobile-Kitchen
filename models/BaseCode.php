<?php

class BaseCode extends BaseModel {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return '{{base_code}}';
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
        'id' => 'ID',
      'F_TCODE' => '类型编码',
      'F_TYPENAME' => '类型名称',
      'F_TYPECODE' => '类型编码',// 树结构
      'F_CODE' => '编码',//型内部F_NAME,_ShowName
      'F_NAME' => '名称',
      'f_value' =>'取值使用',
      'F_SHORTNAME' => '短名称',//，用于输入时使用
      'F_ShowName' => '页面中展示',//的名称,前端描述性展示名称
      'fater_id' => '父级ID',
      'F_ADD' => '说明上课',//处理采用加或减进行计算
      'F_LEN' => '0',
      'F_TYPE' =>'分类类型',
      'F_COL1' =>'表单位置1',///转换GF服务者分值
      'F_COL2' =>'表单位置2',//，/转换GF排名分值
      'open_purchase' => '开放购买折扣',//，1是 2否
      'user_table' => '使用表',
      'user_table_where' => '使用表条件',
      'user_table_list'=> '使用表列表名称',
      'F_IMAG' => '图片类型',
      'F_IMAGEBK' => '图片分界符',
      'F_VIEWNAME' => '关联视图文件名',
      'age_pre' => '年龄上限',
      'age_suf' => '年龄下限',
      'PRODUCT_ID' =>'关联商品',//名称IDmall_products
      'sql_select' => 'sql查询备注',
      'arr_input_set_type' =>'选项类型',
      'if_oper' =>'开放',//，0：否  1：是',
        );
    }
    protected function beforeSave() {
        return true;
    }



  public function getName($id) {
        $rs = $this->find('f_id=' . $id);
        return  str_replace(' ','',is_null($rs->F_NAME) ? "" : $rs->F_NAME);
    }


    public function getCode($fater_id) {
        return $this->findAll('fater_id=' . $fater_id);
    }
    
    public function getAttrtype() {
        return $this->findAll('f_typename="订单类型" order by f_value');
    }
    
    public function getOrderType2() {
        $tmp= $this->getOrderType();
        return toIoArray($tmp,'f_id,F_NAME,fater_id');
    }
    
    public function getOrderType() {
        return $this->findAll('fater_id in(350,360,362,367)');
    }
    
    //return $this->findAll('fater_id in (8,9,189,380,495)');
    //return $this->findAll('fater_id=' . $f_id);
    public function getGrouptypestate() {
        return $this->getCode(32);
    }

    public function getClub_type2() {
        $tmp=$this->getClub_type2_all();
        return toIoArray($tmp,'f_id,F_NAME,fater_id');
    }

   public function getClub_type2_all() {
        return $this->findAll('fater_id in (8,9,189,380,495)');
    }
    //return  $this->findAll("F_TCODE='PARTNAME' and fater_id<>10 and fater_id<>0");

    public function getSex($f_id='0') {
        return $this->findAll('f_id in (205,207)');
    }  
  function get_name_set_by_code($news_id='0') 
{ return  parent::delete_by_key("f_id=".$news_id);}

 function get_combo($code)
  {
       $ws= " f_code='".$code ."' and F_COL2=1  ";//and club_type=".$club_type;
       return $this->findAll($ws);
   }

 function get_combo2($code)
  {
       return $this->get_by_code($code);
   }

       // 学员申请状态
   public function getUsertype() {///695服务者类型描图
        return $this->getCode(886);
    }
   
        // 学员申请状态

  function get_by_code($pcode){
    $s1="left(f_code,".strlen($pcode).")='".$pcode."' and left(f_value,1)<>' '";

    return $this->findAll($s1);
  }

  public function getTcode($ftcod) {
        return $this->findAll("left(f_code,".strlen($ftcod).")='".$ftcod."'");
    }  


    public function getByType($f_type,$f_order='') {
        $criteria = new CDbCriteria;
        $criteria->addCondition("f_type = :f_type");
        $criteria->params[':f_type']=$f_type;
        if(!empty($f_order)) $criteria->order='f_name ASC';

        $result=$this->model()->findAll($criteria);
        return $result;
    }
 
    public function getAllType(){
        $criteria = new CDbCriteria();
        $criteria->select = 'f_type,f_type_CN';
        $result=$this->model()->findAll($criteria);
        return $result;
    }
public function getInputSetType() {
        return $this->findAll('arr_input_set_type > 0');
    }
  public function getGameState() {
        return $this->findAll('f_id in(151, 145, 146, 149)');
    }
  
  
    public function getPurpose() {
        return $this->findAll('fater_id in(829,830)');
    }
    public function getPurpose2($f_id) {
        return $this->findAll('fater_id in(829,830) AND f_id<>'.$f_id);
    }

    public function getCustomer($f_id) {
        return $this->findAll('fater_id=208 AND f_id<>'.$f_id);
    }
    public function getPaytype($f_id) {
        return $this->findAll('fater_id=452 AND f_id<>'.$f_id);
    }
    public function getCounttype($f_id) {
        return $this->findAll('fater_id=711 AND f_id<>'.$f_id);
    }
    /**
     * 传过来的值调用单个或多个
     */
    public function getReturn($f_id,$whe='') {
        return $this->findAll('f_id in('.$f_id.')'.$whe);
    }
    public function getProductType() {
        return $this->findAll('f_id in (361,351,352,353,354,355,356,357,359,364,777,1424,1700,1701,1702)');
    }
  public function getServerType() {
    return $this->findAll('f_id in (351,352,353,354,355,356,357,359,364,777,1424)');
  }
  public function getUpperType() {
    return $this->findAll('f_id in (361,364)');
  }
 
    public function getOrderType1() {
        return $this->findAll('fater_id in(350,362,367)');
    }

    public function getPayway() {
        return $this->findAll('f_id in(483,484,485)');
    }

    //return $this->findAll('fater_id in (8,9,189,380,495)');
    //return $this->findAll('fater_id=' . $f_id);
    public function getClubtype() {
        return $this->findAll('fater_id=10');
    }


    /*wankai tianjia*/
    public function getGame_format() {
        return $this->findAll('fater_id in (984,985,988)');
    }

    public function getGame_format2() {
      $cooperation= $this->getGame_format2_all();
      return toArray($cooperation,'f_id,F_NAME,fater_id');
    }

    public function getGame_format2_all() {
        return $this->findAll('fater_id in (984)');
    }
    public function getTypeCode() {//资质人类型261、identity_
        return $this->getCode(261);
    }

  public function getPicSetType() {//图集/视频./音频251
        return $this->getCode(251);
    }

public function getProjectState() {//项目状态/115
        return $this->getCode(505);
    }
public function getApproveState() {
        return $this->getCode(452);
    }
public function getAuthState() {
        return $this->getCode(455);
    }
public function getapplyType() {
        return $this->getCode(1470);
    }
public function getShenheState() {
        return $this->getCode(370);
    }
public function getPicType() {//125商品图片类型
        return $this->getCode(125);
    }

//PicType:list(Basecode/getPicType)
//资格证书类型122
public function getZheShuType() {///资格证书类型122
        return $this->getCode(122);
    }

//证件扫描图138
public function getZjImg() {///138证件扫描图
        return $this->getCode(138);
    }
public function code1403(){
      return $this->keySelectSet('f_id=1403');
}

public function keySelectSet($w1='f_id=1'){
    return array($w1,'code','id:f_name');
}
//服务者类型383
public function getSservicType() {///388服务者类型描图
        return $this->getCode(383);
    }

   // 开关模式695
   //
   public function getShowState() {///695服务者类型描图
        return $this->getCode(695);
    }

    // 学员申请状态
   public function getStatus() {///695服务者类型描图
        return $this->getCode(336);
    }

  
    // 竞赛项目性别要求
    public function getCode_sex(){
        $cooperation=$this->getCode_sex_all();
        return toArray($cooperation,'f_id,F_NAME,fater_id');
    }

    public function getCode_sex_all() {
        return $this->findAll('fater_id=204');
    }

    // 赛事裁判审核方式
    public function getCode_way(){
        $cooperation= $this->getCode_way_all();
        return toArray($cooperation,'f_id,F_NAME,fater_id');
    }

    public function getCode_way_all() {
        return $this->findAll('fater_id=791');
    }

    // 赛事
    public function getCode_id2() {
        $cooperation= $this->getCode_id2_all();
        return toArray($cooperation,'f_id,F_NAME,F_TYPECODE,fater_id');
    }

     public function getCode_id() {

        return  $this->findAll('fater_id = 169');
    }

    public function temporary() {

        return  $this->findAll('fater_id = 1057');
    }


   public function getCode_id2_all() {
        return  $this->findAll('fater_id in (163,810)');
    }

    public function getQualificationType2() {
    $cooperation= $this->getQualificationType();
    return toArray($cooperation,'f_id,F_NAME,fater_id');
  }

    public function getQualificationType() {
        return $this->findAll('F_TCODE="WAITER" AND fater_id <>383');
    }

    public function getGameArrange2($pid) {
        $cooperation=$this->findAll('fater_id='.$pid);
        return toArray($cooperation,'f_id,F_NAME,fater_id');
      }

    public function getMembertype_all() {
        return  $this->findAll('fater_id in (10,383)');
    }

    public function getMembertype() {
      $cooperation=$this->findAll('fater_id in (10,383)');
      return toArray($cooperation,'f_id,F_NAME,fater_id');
    }

    public function getLogisticsType() {
      //物流状态
      $names='未发货,已发货,已签收,已发货（部份商品）';
      return $this->getWith('物流状态',$names);
    }


public function getSiteType2($f_id) {
      return $this->getNewtype('场地类型');
  }
//待审核未通过编辑中
//$tname='' 是类型,$stype='' 子类型
public function getNewtype($tname='',$stype='') {//
    $w0=' and CONCAT(",",F_SHORTNAME,",") like "%,'.$stype.',%"';
    $w1='(f_tcode="'.$tname.'" or F_TYPENAME="'.$tname.'")';
    $w1.=(empty($stype)) ?'' : $w0;
    return $this->findAll($w1.' order by f_value');
  }
//通过类型或子类活动名字或value值集合
public function getValueSet($tname='',$stype='',$pn='') {//
    $tmp=$this->getNewtype($tname,$stype);
    $vn=(empty($pn)||$pn=='NAME'||$pn=='name') ? 'F_NAME' : 'f_value';
    $rs='"-1"';
    foreach ($tmp as $k => $v) {
       $rs.=',"'.$v[$vn].'"';
    }
    return $rs;
  }

//通过类型或子类活动名字或value值集合
public function getwhereSet($pname ,$tname='',$stype='',$pn='') {
    $rs=$this->getValueSet($tname,$stype,$pn); 
    return $pname.' in ('.$rs.')' ;
  }

//审核对应的value 值
public function getCheckcode($checkcode) {//图集/视频./音频251
    $w1='(F_TCODE="STATE"  or F_TYPENAME="审核状态") ';
    $w1.='and (F_NAME="'.$checkcode.'" or f_ShowName="'.$checkcode.'")';
    return $this->readValue($w1,'f_value');
} 

public function editStateName($fn) {//图集/视频./音频251
   return $this->getwhereSet($fn,'审核状态','编辑中','NAME');
   //return $fn.'in ("待审核","未通过","编辑中")';
}

public function getEditState() {//图集/视频./音频251
  return $this->getNewtype('审核状态','编辑中');
}

public function editCondition($cr,$fname,$state='') {//图集/视频./音频251
    $rs=$this->getValueSet('审核状态','编辑中');
    
    $w1=(empty($state)) ? $rs : '"'.$state.'"';
    return $cr.(empty($cr) ? ' ' :' and ').$fname.' in ('.$w1.')';
}

public function getWith($tname,$names) {//图集/视频./音频251
    $w1='(f_tcode="'.$tname.'" or F_TYPENAME="'.$tname.'")';
    $w1.=' and f_name in ('.$this->getNames($names).')';
    return $this->findAll($w1.' order by f_value');
  }

  function getNames($names){
   $ds=explode(',',$names);
   $rs='';$b='';
   foreach($ds as $v){ //加上路径名称
        $rs.=$b.'"'.$v.'"';$b=',';
    }
    return $rs;
  }
  public function getCondition($tname='',$id) {//图集/视频./音频251
    $w1='f_value="'.$id.'"';
    $w2='f_name="'.$id.'" or F_Showname="'.$id.'"';
    $w0='(f_tcode="'.$tname.'" or F_TYPENAME="'.$tname.'") and (';
    $w0.=(is_numeric($id)) ? $w1 : $w2;
    $w0.=')';
    return $w0;
  }

public function getNewAll($tname,$id) {//图集/视频./音频251
    $w1=$this->getCondition($tname,$id);
    return $this->findAll($w1.' order by f_value');
  }

public function getNewName($tname,$id) {//图集/视频./音频251
    $w1=$this->getCondition($tname,$id);
    //put_msg($w1);
    return $this->find($w1);
  }
public function getPrevious($tname='',$id) {//图集/视频./音频251
    $w1=$this->getCondition($tname,$id);
    $v=$this->readValue($w1,'fater_id');
    return $this->getNewName($tname,$v);
  }

public function getNewValue($tname,$id) {//图集/视频./音频251
    $w1=$this->getCondition($tname,$id);
    return $this->readValue($w1,'value');
  }

}
