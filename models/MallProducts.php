<?php

class MallProducts extends BaseModel {
    public $sel_name='';
    public $product_type_len=6;//同类商品编码长度
    public $product_len=24;//同商品编码长度
    public $project_list = '';
    public $parameter = '';
    public $attr_list = '';
    public $classify_code = '';
    public $description_temp = '';
    public function tableName() {
        return '{{mall_products}}';
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
        'mall_brand_street' => array(self::BELONGS_TO, 'ClubBrand', 'belong_brand'),
        'mall_products_type_sname' => array(self::BELONGS_TO, 'MallProductsTypeSname', 'type'),
        'mall_products_project' => array(self::HAS_MANY, 'MallProductsProject', 'mall_products_id'),
        'base_code' => array(self::BELONGS_TO, 'BaseCode', 'display'),
        'club_list' => array(self::BELONGS_TO, 'ClubList', 'supplier_id'),
        'mall_attribute_type' => array(self::BELONGS_TO, 'MallAttributeType', 'cat_id'),
        'mall_attribute_value' => array(self::HAS_MANY, 'MallAttributeValue', array('product_id'=>'id')),
        );
    }

    public function rules() {
      return $this->attributeRule();
    }

    public function attributeLabels() {
        return $this->getAttributeSet();
    }

public function attributeSets() {
    return array(
    'id' =>'ID',
    'product_code' =>'商品编号',
    'finance_code' =>'财务编号',
    'finance_type' =>'财务分类',
    'finance_type_name' =>'财务分类',
    'name' => '商品名称',
    'product_ICO' => '缩略图',
    'product_scroll' => '详情大图',
    'description' => '详情描述',
    'description_temp' => '详情描述',
    'type_fater' => '商品类型',
    'product_model' =>'商品模式',
    'type' =>'商品分类',
    'material_id' => '素材',
    'material_title' => '素材标题',
    'material_user_dete' => '有效期天数',
    'weigth' => '商品重量',
    'keywords' => '商品关键词',
    'supplier_id' =>'供应商',
    'similar_sale' =>'相关推荐/抢购',
    'sale_desc' => '商品尺码描述',
    'belong_brand' => '所属品牌',
    'add_time' => '申请时间',
    'admin_id' => '操作管理员',
    'admin_nick' => '操作管理员',
    'display' =>'状态',
    'reasons_for_failure' =>'操作备注',
    'update' => '操作时间',
    'clicked' => '商品点击率',
    'IS_DELETE' => '是否删除',
    'sales_quantity' => '销量',
    'project_list' => '项目信息',
    'billing_entity' => '发票单位',
    'cat_id' => '商品类型',
    'attr_list' => '商品规格',
    'parameter' => '商品参数',
    'description_temp' => '详细描述',
    'fd_code' => '财务编号',
    'supplier_code' => '商品货号',
    'Account_code' => '财务编码',
    'json_attr' => '型号/规格',
    'unit' => '商品单位',
    'made_in' => '商品产地',
    'price' => '全国统一零售价',
    'state_time' => '审核时间',
    'sel_name'=>'商品信息'
    );
}

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function keySelect(){
        //这个函数用来做下拉，与视图中的函数相互作用
        //根据单位以及是否审核通过
        $club_id = $_SESSION['club_id'];//2450
        return array('supplier_id='.$club_id,'id','id:sel_name');//右边给别人看，左边是标签的value值
    }

    protected function afterFind() {
        //从数据库取值就会操作
        parent::afterFind();
        $this->sel_name=$this->product_code.'-'.$this->name;
        return true;
    }

    protected function beforeSave() {
        parent::beforeSave();
        
        // 图文描述处理
      
        $this->description=getAboutMe($this,'description');
        $this->add_time = date('Y-m-d h:i:s');
       
        if ($this->isNewRecord) {

            $this->add_time = date('Y-m-d h:i:s');
            $this->sales_quantity = 0;
        }

//生成商品编号
        $supplier_code='';
        $supplier=ClubList::model()->find('id='.$this->supplier_id); 
        if(!empty($supplier)){
           $supplier_code.=$supplier->club_code; 
        }    
        $gf_code=substr($this->type, -8);
        $product_code='';
        $se1='IS_DELETE=510 AND code like "'.$gf_code.'%" order by code DESC';
        $se='IS_DELETE=510 AND code like "'.$gf_code.'%" and name="'.$this->name.'"';
        $ptype=$this->find($se1);
        if(!empty($ptype)){
            $product=$this->find($se.' order by code DESC');
            if(!empty($product) && !empty($product->code)){
                $name_code=substr($product->code,0, 14);
                $pattr=$this->find('IS_DELETE=510 AND code like "'.$name_code.'%" and name="'.$this->name.'"'.' and json_attr="'.$this->json_attr.'" order by code DESC');
                if(!empty($pattr)){
                    $product_code=$pattr->code;
                } else{
                    $attr_code=substr($product->code, -2);
                    $acode = substr('00' . strval(intval($attr_code)+1), -2);
                    $product_code=substr($product->code, 0, -2).$acode;
                }
            } else{
                $pro_code=substr($ptype->code,8, -2);
                $pcode = substr('000000' . strval(intval($pro_code)+1), -6);
                $product_code=$gf_code.$pcode.'01';
            }
        } else{
            $product_code=$gf_code.'00000101';
        }
        $this->code=$product_code;
        $this->product_code=$supplier_code.$product_code;


        $this->admin_id = Yii::app()->session['admin_id'];
        $this->admin_nick = Yii::app()->session['gfnick'];
        $this->update = date('Y-m-d h:i:s');

        return true;
    }

    function get_type_code($code) {
    $rs="";
    for ($i=1;$i<5;$i++){
         $typeInfo= substr($code,0,($i*2-1));
        if(!empty($typeInfo1)) {
          $rs.=(($i==1) ? "" : ",").$typeInfo;
         } 
      }
        return $rs;
    }

}
