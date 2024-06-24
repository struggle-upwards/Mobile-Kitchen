<?php

class testPriceinfo extends BaseModel {
    public $service_check='';
    public function tableName() {
        return '{{test_price_info}}';
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
      'code' => '编码:k',
      'name' =>'策略名称:k',
      'clubcode'=> '社区编码',
      'clubname' =>'社区名称',
      'place_type' =>'场地类型',
      'policy_id' => '时间策略',
      'policy_name' => '时间名称',
      'memo' => '备注',
      'service_type' =>'服务类型',// 1 场地  3 服务者
      'service_name' => '服务类型',
      'service_set' => '服务类型',//服务者类型集合，字符串
      'service_check' => '服务类型',//服务者类型集合，数组集合
      'usermark'=> '在使用',
      );
    }

    //关联数据自动处理
    public function getrelations() {
      $s1='clublist,clubcode:club_code,clubname:club_name;';
      return $s1.'testTimePolicy,policy_id:id,policy_name:name';    
      return $s1;
    }

  public function oldesetDefaultValue() {
      $relations='clublist,clubcode:club_code,clubname:club_name;';
      $relations.='testTimePolicy,policy_id:id,policy_name:name';

      //$relations.='clublist,clubcode:club_code,clubname:club_name';
      $rs=array(
      'sess'=>'',//保持登录信息
      'date'=>'',//保存修改
      'def_sess'=>'',//保持第一次操作信息
      'def_date'=>'',//保存地一次修改信息
      'pcipath'=>'',//属性名:模型名称，模型空取上一个模型
      'relations'=>$relations//关联取值
      );
      return $rs;
    } 
  //public function picLabels() {return 'subpic';}
  //public  function pathLabels(){ return '';}
   /* 用于列表查询使用，三个参数分别是  1 条件 2 是排序 三是或取值，格式 变量[：变量]*/
    public function keySelect(){
        return array('1','code','code:name');
   }

   public function clubSelect(){
      $w1='clubcode="'.$_SESSION['club_code'].'"';
      $tmp=$this->findAll($w1.' order by code');
      return array($tmp,'id:name');
   }

    protected function beforeSave() {
        parent::beforeSave();
        if(is_array($this->service_set)){
          $this->place_type=$this->service_set[0];
          $this->service_set= implode(',',$this->service_set);
        }
        return true;
    }

     protected function afterFind() {
        parent::afterFind();
        $this->service_check=explode(',',$this->service_set);
        return true;
    }
}
