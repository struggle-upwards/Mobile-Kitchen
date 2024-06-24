<?php

class ClubadminController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

public function actionIndex($keywords='',$lang_type='0',$club_id=-1) {
    set_cookie('_currentUrl_', Yii::app()->request->url);
    $modelName = $this->model;
    $model = $modelName::model();
    $criteria = new CDbCriteria;
    if ($club_id<0) $club_id=get_session('club_id'); 
    $w1=get_like('club_id='.$club_id,$lang_type,'lang_type');
    if($lang_type==0) $w1='lang_type=0';
    $s1='admin_gfaccount,admin_gfnick,club_name';
    $criteria->condition=get_like($w1,$s1,$keywords,'');
    $data=array();
    $data['tname']=get_session('club_name');
    parent::_list($model,$criteria,'index', $data);
    }

    public function actionCreate() {
        $this->actionUpdate(0);
    }
 
    public function actionUpdate($id=0) {
        $_POST=$_REQUEST;
        $this->showView($id,'update');
    }
	
    public function actionUpdateopt($id=0) {
        $modelName = $this->model;
         if(isset($_POST['role_name']))
        $_POST[$modelName]['role_name']=$_POST['role_name'];
         $this->showView($id,'updateopt');
    }

    public function actionAccountsecurity($id) {
        $this->showView($id,'accountsecurity');
    }
    
   public function showView($id,$view) {
        $modelName = $this->model;
        $model = new $modelName('create');
        if(!empty($id)) $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['role'] = Role::model();
            $data['tname'] =get_session('club_name');
            $this->render($view, $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }
	function saveData($model,$post) {
        $model->attributes =$post;
        if(!empty($post['role_name'])){
            $rolename = $post['role_name'];
            $model->role_name = $rolename ;
            $model->admin_level = Role::model()->find('f_rname="'.$rolename.'"')->f_id;
        }
        $model->last_login = date('Y-m-d H:i:s');
        $sv=$model->save();
        show_status($sv,'保存成功', returnList(),'保存失败.');
    }
	
    function actionresetPassword($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $pass=rand(100000,999999);
        $this->saveChangeData($model,array('password'=>$pass));
        system_message($model->admin_gfid,"账号：".substr($model->admin_gfaccount,1,4).'XXXX,后台登录密码：'.$pass);
         ajax_status(1, '密码设置成功', returnList());   
    }
    // 修改密码
    public function actionChange_password($id=0) {
        $id=($id) ? $id : get_session('admin_id');
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('change_password', $data);
        } else {
		    $this->saveChangeData($model,$_POST[$modelName]);
          show_status($sv,'保存成功',Yii::app()->request->urlReferrer,'保存失败.');
        }
    }
    // 修改密码
function saveChangeData($model,$post) {
    $model->attributes =$post;
    $model->ec_salt = rand(1,9999);
    $model->password=$this->getPassMd5($model,$post['password']);
    $sv=$model->save();
}
	// 验证密码是否正确
public function actionVerifyPassword($id=0,$password=0) {
    $model=Clubadmin::model()->find('id='.$id);
    if(!empty($model)){
        $passMd5=$this->getPassMd5($model,$password);
        if($passMd5!==$model->password){
            ajax_status(0, '密码错误');
        }
    }
}

public function getPassMd5($tmp,$inpass){
    $salt=$tmp->ec_salt;
    $acc =$tmp->club_code.'#'.$tmp->admin_gfaccount;
    $p = md5(trim($acc).$inpass);
    return pass_md5($salt,$p);
}

    public function actionStatus($id, $status = 0) {
        parent::_status($id, $status);
    }

    public function actionDelete($id) {
       parent::_clear($id);
    }
    //首页创建登录账号
	public function actionCreateAdmin($phone,$password){
        $temp = QmddAdministrators::model()->find('phone="'.$phone.'"');
        if(!empty($temp)){ 
            ajax_status(0, '手机号已注册');
            return;
        }
        $user = new QmddAdministrators;
        $user->club_id=substr(getAutoNo('Clubadmin',$phone,''),-4);
        $user->phone=$phone;
        $user->ec_salt = rand(1,9999);
        $user->password = pass_md5($user->ec_salt,123456);
        $user->save();
        $user->admin_gfaccount=$phone;
        $user->admin_gfnick='用户'.$user->club_id;
        $user->save();
        if(empty($user->getErrors())){
            $_SESSION['gfnick']=$user->admin_gfnick;
            $_SESSION['gfid']=$user->admin_gfid;//这里为帐号gf_account
            $_SESSION['gfaccount'] =$phone;
            $_SESSION['level'] =$user->admin_level; //管理员级别 平台管理员级，普通社区为0.admin_gfnick
            $_SESSION['club_id'] =$user->club_id;
            //$_SESSION['club_code'] =$tmp['club_code'];
            $_SESSION['name']= $_SESSION['gfnick'];
            $_SESSION['admin_id']= $user->id;
            $_SESSION['club_name'] =$user->club_name;//$_SESSION['gfnick'];//
            ajax_status(1, '');
        }else ajax_status(0, '注册失败');
    }

}
