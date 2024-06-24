<?php

class ClubListGys extends BaseModel {
	public $club_list_pic='';
	public $about_me_temp = '';
	public $brand_name = '';
	public $brand_logo = '';
	public $brand_lock = '';
	public $remove_brand_ids = '',$apply_times='';
	public $show=0;
    public function tableName() {
        return '{{club_list}}';
    }

 	public function check_save($show) {
        $this->show=$show;
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
            'no' => '序号',
			'club_code' => '单位管理账号',
			'financial_code' => '财务编码',
			'club_name' => '商家名称',
			'club_logo_pic' => 'LOGO',
			'apply_club_gfid' => 'ID',
			'apply_club_gfaccount' => '申请人帐号',
            'apply_gfaccount' => '账号',
			'club_type' => '类型',
			'club_type_name' => '类型',
			'partnership_type' => '商家类型',
			'partnership_name' => '商家类型',
			'individual_enterprise' => '申请方式',
			'individual_enterprise_name' => '申请方式',
			'company' => '供应商名称',
			'apply_club_gfnick' => '法人/负责人姓名*',
			'apply_club_id_card' => '身份证号码',
			'apply_club_phone' => '电话号码',
			'apply_club_email' => '邮箱',
			'id_card_face' => '身份证正面',
			'id_card_back' => '身份证反面',
			'organization_code' => '机构代码',
			'certificates_number' => '统一社会信用代码',
			'certificates'=>'营业执照',
			'valid_until_start' => '营业开始时间',
			'valid_until'=> '营业结束时间',
			'management_category' => '经营类目',
			'apply_name' => '联系人',
			'contact_phone' => '联系人电话',
			'email' => '联系人邮箱',
			'apply_id_card' => '联系人身份证',
			'con_address' => '联系人地址',
			'contact_id_card_back' => '联系人身份证反面',
			'contact_id_card_face' => '联系人身份证正面',
			'club_list_pic' => '营业执照',
			'recommend' => '推荐单位',
			'bank_name' => '开户名称',
			'bank_branch_name' => '开户行支行名称',
			'bank_account' => '银行帐号',
            'bank_pic' => '银行开户许可证',
			'club_area_country' => '国家',
			'club_area_province' => '省',
			'club_area_district' => '区县',
			'club_area_city' => '市',
			'club_area_street' => '所在区域街道',
			'club_address' => '单位所在地',
			'latitude' => '纬度',
			'Longitude' => '经度',
			'service_hotline' => '客服服务热线',
			'apply_time' => '申请日期',
			'uDate' => '更新时间',
			'isRecommend' => '是否推荐社区',
			'recommend_club_name' => '推荐社区名',
			'is_invoice' => '开发票',
			'invoice_category' => '发票类型',
			'invoice_product_id' => '发票收费关联商品',
			'about_me'=> '关于我们',
			'state' => '审核状态',
			'state_name' => '状态名称',
			'edit_state' => '认证状态',
			'edit_state_name' => '认证状态',
			'if_del' => '是否删除',
			'news_clicked' => '点击率',
			'book_club_num' => '订阅数',
			'beans' => '社区体育豆',
			'club_credit' => '收益积分',
			'dispay_xh' => '显示序号',
			'reasons_for_failure'=>'操作备注',
			'edit_reasons_for_failure'=>'操作备注',
			'data_belong_code' => '单位归属编码',
			'mall_belong_code' => '商城数据归属码',
			'visible' => '是否显示前端',  // 0不显示，1显示',
			'brand_name' => '品牌名称',
			'brand_logo' => '品牌logo',
			'brand_lock' => '品牌简介',
			'brand_id' => '品牌id',
			'brand_ids' => '品牌id合集',
			'club_area_code' => '社区单位区域编号',
            'taxpayer_type' => '是否为一般纳税人',
            'taxpayer_pic' => '一般纳税人证明上传',
            'qualification_pics' => '资质附件',
            'is_read' => '已阅读并同意',
            'company_type_id' => '供应商类型',
            'pass_time' => '审核时间',
            'edit_apply_time' => '申请时间',
            'edit_pass_time' => '审核时间',
		);
	}
    public function gysAttributeLabels() {
        $tmp=array(
			'club_code' => '编码:100',
			'club_name' => '名称:200',
			'partnership_type' => '类别:100',
			'club_address' => '所在地区:200',
			'apply_name' => '联系人:80',
			'contact_phone' => '联系电话:100',
			'apply_times' => '创建时间:100',
			'state_name' => '状态:100',
		);	
		$s1='';$s0="<th style='text-align:center;";
        $rs=array();
		foreach( $tmp as $k=>$v){
          $d1=explode(":",$v);
          $rs[]=$k;
          $s1.=$s0. 'width: '.$d1[1].'px;' ."'>". $d1[0] ."</th>";
         }
        return array($s1,$rs);
	}

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
	}

  public function picLabels() {
        $s1='club_logo_pic,id_card_face,contact_id_card_face';
        $s1.='id_card_back,certificates,contact_id_card_face,';
        return $s1.'apply_id_card,club_list_pic,bank_pic,taxpayer_pic';
    }
    public function pathLabels(){ return '';}

    public function getrelations() {
      $s1='ClubList,recommend_clubcode:club_code,recommend:id&recommend_clubname:club_name;';
      $s1.='userlist,apply_club_gfid:gf_id,apply_gfaccount:GF_ACCOUNT&apply_name:ZSXM';
      $s1.='&apply_club_gfaccount:apply_gfaccount';
      return $s1;
    }

	protected function afterSave() {
		parent::afterSave();
    }

	protected function afterFind() {
		parent::afterFind();
		$this->apply_times= dateLine2($this->apply_time);
    }

	protected function beforeSave() {
        parent::beforeSave();
       //if($this->state==2){
        QmddAdministrators::model()->checkClubUser($this);
		// 图文描述处理
        $this->about_me=getAboutMe($this,'about_me');
		$this->apply_time = date('Y-m-d h:i:s');
        $this->setReasons();
        $this->setDistrict();
        return true;
	}

   public function setReasons(){
   	 $this->about_me_time = date('Y-m-d h:i:s');
   	 $this->reasons_adminid = Yii::app()->session['admin_id'];
     $this->reasons_adminname = Yii::app()->session['gfnick'];
     $this->uDate = date('Y-m-d h:i:s');
   }

   public function setDistrict() {
      $ds=TRegion::model()->getDistrict($this->club_area_code);
      $this->club_area_province=$ds['province'];
      $this->club_area_city=$ds['city'];
      $this->club_area_district=$ds['district'];
    }

    public function getCode($club_type) {
        return $this->findAll('club_type=' . $club_type);
    }

	public function getID($id) {
        return $this->findAll('id=' . $id);
	}

	public function getRecursionName($id,$t='') {
		$fater_id = ClubProductsType::model()->find('id='.$id);
		$text=$t;
		if(!empty($fater_id->ct_name)){
			$text=$fater_id->ct_name.'-'.$text;
		}
		if(!empty($fater_id->fater_id)){
			$this->getRecursionName($fater_id->fater_id,$text);
		}else{
			if($_REQUEST['r']=='clubList/index'){
				echo rtrim($text, '-').'<br>';
			}else{
				echo rtrim($text, '-');
			}
		}
    }
}
