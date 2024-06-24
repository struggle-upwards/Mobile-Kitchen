<?php

class ClubListSqdw extends BaseModel {
    public function tableName() {
        return '{{club_list}}';
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
            'id' => 'ID',
            'no' => '序号',
			'club_list_pic' => '单位图片',
			'club_code' => '单位编号',
			'financial_code' => '财务编码',
			'club_name' => '单位名称',
			'club_logo_pic' => '单位图片',
			'apply_club_gfid' => 'ID',
			'apply_club_gfaccount' => '账号',
			'apply_card_id' => '从业资质',
			'apply_card' => '从业资质',
			'club_type' => '类型',
			'club_type_name' => '类型',
			'partnership_type' => '单位类型',
			'partnership_name' => '单位类型',
			'individual_enterprise' => '入驻类型',
			'individual_enterprise_name' => '入驻类型',
			'company' => '申请单位名称',
            'company_type_id' => '单位性质',
			'company_type' => '单位性质',
			'apply_club_gfnick' => '姓名',
			'apply_club_id_card' => '身份证号',
			'apply_club_phone' => '联系电话',
			'apply_club_email' => '联系邮箱',
			'id_card_face' => '身份证（正面）',
			'id_card_back' => '身份证（反面）',
			'organization_code' => '机构代码',
			'certificates_number' => '统一社会信用代码',
			'certificates'=>'营业执照',
			'valid_until_start' => '营业期限',
			'valid_until'=> '至',
			'management_category' => '经营类目',
			'apply_name' => '姓名',
			'contact_phone' => '联系电话',
			'email' => '电子邮箱',
			'apply_id_card' => '身份证号码',
			'con_address' => '联系地址',
			'contact_id_card_back' => '身份证反面',
			'contact_id_card_face' => '身份证正面',
			'recommend' => '推荐单位id',
			'recommend_clubcode' => '推荐单位账号',
			'recommend_clubname'=>'推荐单位名称',
			'bank_name' => '开户名称',
			'bank_branch_name' => '开户行支行名称',
			'bank_account' => '银行帐号',
			'bank_pic' => '银行开户许可证',
			'club_area_country' => '国家',
			'club_area_province' => '省',
			'club_area_district' => '区县',
			'club_area_city' => '市',
			'club_area_street' => '所在区域街道',
			'club_address' => '单位地址',
			'latitude' => '纬度',
			'Longitude' => '经度',
			'service_hotline' => '客服服务热线',
			'apply_time' => '申请日期',
			'edit_apply_time' => '申请时间',
			'uDate' => '更新时间',
			'pass_time'=>'审核时间',
			'edit_pass_time'=>'审核时间',
			'reasons_adminid' => '操作员',
			'reasons_adminname' => '操作员',
			'isRecommend' => '是否推荐社区',
			'recommend_club_name' => '推荐社区名',
			'is_invoice' => '开发票',
			'invoice_category' => '发票类型',
			'invoice_distribution_mode' => '发票配送方式',
			'invoice_authorized_book' => '票种核定书',
			'invoice_product_id' => '发票收费关联商品',
			'about_me'=> '关于我们',
			'state' => '审核状态',
			'state_name' => '审核状态',
			'edit_state' => '审核状态',
			'edit_state_name' => '审核状态',
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
            'club_area_code' => '社区单位区域编号',
            'company_registered_capital' => '注册资本',
			'enter_project_id' => '入驻项目',
			'approve_state' => '认证方式',
			'qualification_pics' => '上传协议',
			'taxpayer_type' => '是否为一般纳税人',
			'taxpayer_start_time' => '一般纳税人证明有效期',
			'taxpayer_end_time' => '至',
			'taxpayer_pic' => '一般纳税人证明上传',
			'unit_state' => '状态',
			'unit_state_name' => '状态',
			'lock_date_start' => '注销时间',
			'reviewCom' => '审核意见',
			'lock_date_end' => '注销结束时间',
			'Description' => '单位介绍'
       );
    }

	protected function afterSave() {
		parent::afterSave();
		return true;
	}

	protected function beforeSave() {
        parent::beforeSave();
        return true;
	}


//暂时不要，不懂这个封装，导致每次操作之后都会添加uploads/temp，导致变成无效图片
	// public function picLabels() {
    //     return 'club_logo_pic';
    // }

    public function keySelect(){
        return array("audState='审核通过'",'id','club_name');
    }
    //创建后端登录账号
    public function createAdminUser(){
        if(!isset($this->club_code)) return;
        $club_code = $this->club_code;
        //查重
        $temp = QmddAdministrators::model()->find('club_code="'.$club_code.'"');
        if(!empty($temp)) return;
        $user = new QmddAdministrators;
        $user->club_code=$club_code;
        $user->admin_gfaccount=$club_code;
        $user->club_name=$this->club_name;
        $user->ec_salt = rand(1,9999);
        $user->password = pass_md5($user->ec_salt,123456);
        $user->club_id=$this->id;
        // $user->partnership_type=624;
        // $user->partnership_name='项目公司';
                $user->partnership_name='厨房单位';
          $user->admin_level=291;
           $user->role_name='厨房管理员';     
        $user->lang_type=0;
        $user->email=$this->email;
        $user->save();
    }

}
