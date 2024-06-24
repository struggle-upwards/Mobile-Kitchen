<?php

class Menu extends BaseModel {
    public $role_code='';
        /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{qmdd_menu_test}}'; //'菜单及权限'
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
       
  'f_id' => '内部ID',
  'f_mid' =>'父级ID,本表ID',
  'f_code' => '菜单编码',
  'f_name' =>'菜单名称',//--跆拳道
  'f_nameb' =>'三级菜单',
  'f_namec' =>'三级名称',
  'f_sname' => '',
  'f_mtype' => '菜单类型',//，1表示一级菜单，2表示二级菜单
  'f_url' => '菜单跳转',
  'f_model'=> '操作表模式',//的处理，模型名用豆号分开
  'f_action'=> '动作名称',
  'f_opcode'=> '查找',
  'f_opcode2'=>'详细操作名称',
  'f_ty' => '0',
  'f_type' => '菜单归属主菜单',
  'f_typename'=>'一级菜单名称',
  'f_pcode'=> '一级菜单',
  'f_imgshow' => '收起展示图标',
  'f_imgdown' => '下拉显示图标',
  'f_temp' => '临时使用',//，0表示不是，1表示是未审核单位使用
  'f_btype' =>'新类型',
  'f_bcode' => '新编码',
  'f_bname' =>'新名称'
        );
    }


    protected function beforeSave() {
        return true;
    }

    protected function afterFind(){
      parent::afterFind();
      $s1=$this->f_url;
      $s2='qmdd/../qmdd2018/';
      if(indexof($s1,$s2)>=0){
        $this->f_url=str_replace($s2,'',$s1);
      }
 
    }

    public function getMenu($ptypecode="",$ptc="") {
        $fp1 =Role::model()->getParent($ptypecode,$ptc);
        $pset='0';
        if(is_null($fp1)) $fp1="";
        $fp1=str_replace(' ','',$fp1);
        if(!empty($fp1)){
          $pset=str_replace('|',',',$fp1);
        }
        $ws='(F_mtype=2 or F_mtype=0) '.(($ptc=="") ? "" : ' and f_id in ('.$pset.")");
        return $this->get_rec($ws);
    }

     function get_rec($ws=""){
        $criteria = new CDbCriteria() ;     
        $criteria ->condition =$ws;  
        $criteria->order='f_code'; 
        return $this->findAll($criteria);   
     }

//获得角色父亲的权限
    function get_rec_by_code($prcode=""){
        return $this->get_rec($this->get_parent_opter($prcode,1));   
     }        
//获得角色父亲的权限
    function get_parent_opter($prcode="",$ptype=0){
        $ln=strlen($prcode);
        $prcode=($ln<1) ? "" : "f_rcode='".substr($prcode,0,$ln)." '";
        if(!empty($prcode)){
            
           $tmp=Role::model()->find($prcode);
           $prcode="";
           if (!empty($tmp)){
            $prcode=($ptype==0) ? $tmp['f_opter'] : 'f_id in ('.$tmp['f_opter'].') or f_mtype=1';
           }
       }
        return $prcode;   
     }    


     function get_menu( $level,$all=0)
      {
         $spl_level = str_split( $level );
         $menu = array ();
         $menu1=$this->get_rec('f_mtype>0');;
         foreach ( $menu1 as $mk => $mv ) {
                $node=recToarray($mv,'f_id,f_code,f_name,F_mtype,f_url');
                $spl_role = str_split( $node['f_role']  );
                $isIntersect = array_intersect( $spl_level, $spl_role );
                $node['cando']=(! empty( $isIntersect ))? 1 : 0 ;
                if ((! empty($isIntersect))  or ($all==1)) {
                    $menu[] = $node;
                }
            }
        return $menu;
    }

//取菜单的代码第一个字母
    function get_menu_code($menustr)
      {
         $mcode_str='';
        if(empty($menustr)) { $menustr='0';}
         $list =$this->get_rec("f_id in (".$menustr.') ');
         $bk="";
         foreach ($list as $da1){
             $c=substr($da1['f_code'],0,1);
             if (indexof($mcode_str,$c)<0) 
             { $mcode_str.=$bk.$c;
             $bk=",";}
        }
     return $mcode_str;
  }


   function add_chose($p1,$p2){
    $da2=explode(',',$p2);
    $b1=',';
    foreach ($da2 as $c){
        $this->role_code.=$b1.$c.$p3;
        if (!empty($c)){
           if (indexof($b1.$p1.$b1,$b1.$c.$b1)<0)  $p1.=$b1.$c;
         }
        }
    return  $p1;
   }

//,$allm=0菜单的资源功能
  function get_menu_new($mids='',$allm=0,$pmodename=""){
    if(empty($mids)){
      $mids="0";
    }
    $ws1="left(f_url,1)<>' ' and (f_id in (".$mids.') or f_id>=13600)';
    if (!empty($pmodename)){
       $ws1.=" and  f_model='{$pmodename}'";
    }
    return $this->get_rec($ws1); 
  }


   function get_oper($pid,$p2){
     return  indexof($this->role_code,$pid.$p2)>=0;
    }

function get_menu_with_rolestr($rolestr){
     $menuidstr="";$b1="";
     $rolestr=str_replace(',,',',',$rolestr);
     $rolestr=(empty($rolestr)) ? '0' : $rolestr;
     $list = Role::model()->findAll('f_id in (' .$rolestr.')');
    foreach ($list as $da1){
        $d1=explode(',',$da1['f_opter']);
        foreach ($d1 as $da2){
        if(!empty($da2)){
            if (!(strstr(','.$menuidstr.',',",".$da2.',')))
          $menuidstr.=$b1.$da2;$b1=',';
          }
        }
      }
    return $this->get_menu_new($menuidstr,1);
}

function get_menu_fid($rolestr,$pmodename=""){
	$menuidstr="0";
	$rolestr=str_replace(',,',',',$rolestr);
	$rolestr=(empty($rolestr)) ? '0' : $rolestr;
	$list = Role::model()->findAll('f_id in (' .$rolestr.') ');
	$this->role_code='';
	$do = ',';
	foreach ($list as $da1) {
		if(!empty($this->role_code) && substr($this->role_code,-1)!=',') $this->role_code .= $do;
		$this->role_code .= $da1['f_opter'];
	}
	$this->role_code=substr($this->role_code,1);
    return $this->get_menu_new($this->role_code,1,$pmodename);
}
//活动角色所授权权限
function get_role_power($rolestr,$pmodename=""){
    $menu=$this->get_menu_fid($rolestr,$pmodename);//所有菜单资源功能
    return $this->role_oper( $menu);
  }

function role_oper($menu){
    $r_op=array();$mj=0;
    foreach ( $menu as $mk => $mv ) {
     if (($mv['f_mtype'] >'2')||($mv['f_mtype'] == '0')) {
        $mname=strtolower(str_replace(' ','',$mv['f_model']));
        $id=$mv['f_id'];
         $opn=trim(strtolower($mv['f_opcode']));
         $action=trim(strtolower($mv['f_action']));
        if ((strlen($mname)>0)&&(strlen($opn)>0)&&(strlen($action)>0)) {

          $opn=trim(strtolower($mv['f_opcode']));
          $r_op[$mname][$action][$opn]=1;
          if(($opn=='create')||($opn=='update')) {
             $r_op[$mname][$action]['baocun']=1;
           };
           if(($opn=='shehe')) {
             $r_op[$mname][$action]['tongguo']=1;$r_op[$mname][$action]['butongguo']=1;
             $r_op[$mname][$action]['quxiao']=1;$r_op[$mname][$action]['update']=1;
           };
        }
     } 
    }
    return $r_op;
  }

public  function getNewmenu($rolestr="0",$p1="",$ptype='A'){
  $menu=$this->getAllmenu('',$p1,$ptype,$rolestr);//,$role_code);
  $menus=array();
  foreach ( $menu as $mk => $mv ) {
      put_msg($mv['f_code']);
      $ckey = trim($mv['f_code']);
      $key = substr($ckey,0,3);
      if(!isset($menus[$key]['label'])){
         $menus[$key]=$this->getMenu2( $key);
      }
      $menus[$key]['children'][$ckey]['label'] = $mv['f_name'];
      $url =$mv['f_url'];
      if (indexof($url,'http')<0){ $url=''.trim($url); }
      if (indexof($url,'service-chats')>=0){
       $url.=$aec;
       $menus[$key]['children'][$ckey]['lang_type'] =  $s0;
      }else if(indexof($url,'service_chat')>=0){
        $url .= '&id='.$_SESSION['admin_id'];
      }
      $menus[$key]['children'][$ckey]['action'] =trim( $url );
      $menus[$key]['children'][$ckey]['f_mtype'] =$mv['f_mtype'];
      $menus[$key]['children'][$ckey]['f_imgshow']=$mv['f_imgshow'];
      $menus[$key]['children'][$ckey]['f_imgdown']=$mv['f_imgdown'];
    }
    return $menus;
  }

  function getAllmenu($menustr,$allm=0,$f_type='A',$rolestr="0"){
    $role_oper = QmddRoleNew::model()->find('f_id='.$rolestr)['f_opter'];
    put_msg($role_oper);
    $w1='f_mid=0 and f_code like "'.$f_type.'%" and f_mtype =2';
           // 将$role_oper字符串分割成数组，以便使用FIND_IN_SET函数
    $roleArray = explode(',',$role_oper);
    
    // 构建包含所有f_id条件的字符串
    $roleIdConditions = '';
    foreach ($roleArray as$roleId) {
        $roleIdConditions .= 'FIND_IN_SET('.$roleId.', f_id) OR ';
    }
    
    // 移除最后一个OR
    $roleIdConditions = rtrim($roleIdConditions, ' OR ');
    
    // 添加到$w1条件中
    $w1 .= ' AND (' .$roleIdConditions . ')';
   return  $this->findAll($w1.' order by f_code');
  }

  function getMenu2($f_type='A'){
    $mv=$this->find('f_code like "'.$f_type.'%" order by f_code');
    $rs=array();
    $rs['label'] = $mv['f_name'];
    $rs['f_mtype'] = $mv['f_mtype'];
    $rs['f_imgshow'] =trim( $mv['f_imgshow'] );
    $rs['f_imgdown'] =trim( $mv['f_imgdown'] );
    return $rs;
  }

  function mlist($para='a&b'){
    //$d1=explode("&");
    $w1='f_mid=0 and f_mtype=2 and f_code like "'.$para.'%"';
    $tmp=$this->findAll($w1.' order by f_code');
    return array($tmp,'f_id:f_name');
  }


  //获得的角色的权限菜单
function get_role_menu($rolestr,$aes_str='0'){
    $menu=$this->get_menu_with_rolestr($rolestr,0);//只显示一级菜单的前夕
    $_SESSION['role_access']= $this->role_oper( $menu);
    $list = array();
    $si=-1;
    foreach ( $menu as $mk => $mv ) {
        put_msg('mv1'.$mv);
        if ($mv['f_mtype'] == '1') {
            if($si>=0){
                $list[$si]=array($name0,$menu0);
             }
             $name0= $mv['f_name'];
             $menu0=array();
             $si += 1;
        } else {
            $s0=trim($mv['f_url']);
            if (indexof($s0,"?-1")>=0){
              $s0=str_replace("?-1","?".$aes_str,$s0);
            } else{
            $s0=trim(str_replace("../qmdd2018/index.php?r=","",$mv['f_url']));//?-1
        }
          $menu0[$mv['f_code']]=array( $mv['f_name'],$s0);
        }
    }
    $list[$si]=array($name0,$menu0);
    put_msg($list);
    return $list;
  }
}
 

