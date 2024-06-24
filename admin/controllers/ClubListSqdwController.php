<?php
class ClubListSqdwController extends BaseController{//与模建立联系
    protected $model = '';
    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
     }

    public function actionDelete($id) {
        parent::_clear($id);
    }

    function saveData($model,$post) {
        $model->attributes = $post;

        show_status($model->save(),'保存成功',get_cookie('_currentUrl_'),'保存失败');  
     }


    public function actionIndexlist($keywords='') { 
         $this->showIndex($keywords,'index_list','待提交');
    }

public function actionCreate() {
    $model = new ClubListSqdw;
    $data = array();
    if (!Yii::app()->request->isPostRequest) {

        $data['model'] = $model;
        $siteCode = setGetValue('siteCode',getAutoNo('ClubListSqdw'));
        $data['siteCode'] = $siteCode;
        $data['sign'] = 'create';
        $this->render('update', $data);
    }else{
        $model->state = 371;//审核中
        $model->state_name='待提交';
        $model->attributes = $_POST["$this->model"];

        // $model->club_logo_pic = 'uploads/temp/'.$model->club_logo_pic;
        // put_msg($model->club_logo_pic.'----------------');
        $model->club_code = setGetValue('siteCode');
        $this->saveData($model,$_POST["$this->model"]);
    }
}

    public function actionUpdate($id,$index='') { 
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            put_msg('is not   in update');
            $data['model'] = $model;
            if($index == 'index_pass') $data['sign'] = 'index_pass';
            else $data['sign'] = 'update';
            $this->render('update', $data);
        } else {
             put_msg('is    in update');
            if($index == 'index_pass'){ 
                $model->state = 372;//审核通过
            }
            else $model->state = 721;//编辑中
            $this->saveData($model,$_POST["$this->model"]);
        }
    }

    public function actionTijiao(){
        $modelid = $_REQUEST['modelid'];
        $modelName = $this->model;
        $model = $modelName::model()->find("id='$modelid'");
        put_msg($model->club_logo_pic);
        $model->state = 371;//'待审核';
        $model->state_name = '待审核';//'待审核';
        $model->save();
        put_msg($model->club_logo_pic);
        $data = array('modelid'=>$modelid);
        echo CJSON::encode($data);
    }

    public function actionIndexcheck($keywords='') {    
        $this->showIndex($keywords,'index_check','待审核');
    }

    public function actionIndexfail($keywords='') {
       $this->showIndex($keywords,'index_fail','审核不通过');
    }

   function showIndex($keywords,$view,$sname,$pn=0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $w1="state_name='".$sname."'";
        $s1='club_code,club_name';
        $criteria->condition =get_like($w1,$s1,$keywords,'');
        $criteria->order = 'id';
        $data = array();
        if($pn==0) {
            parent::_list($model, $criteria, $view, $data);
         } else{
           parent::_list($model, $criteria,$view, $data, 15);
         }
    }


    public function actionUpdatecheck($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
    if (!Yii::app()->request->isPostRequest) {
        $data['model'] = $model;
        $this->render('update_check', $data);
    }else{
            put_msg('102');
            put_msg($_POST['submitType']);
            if($_POST['submitType'] == 'notpass') {
                $model->state = 373;//'审核不通过';
                 $model->state_name = '审核不通过';//'审核不通过';
            }
            if($_POST['submitType'] == 'pass') {
                put_msg('110');
                $model->state = 372;//'审核通过';
                $model->state_name = '审核通过';//'审核通过';
                $model->createAdminUser();
                put_msg('114');
            }
            $s1 = $model->save();
            if($s1) put_msg('100');
            show_status($model->save(),'操作成功',get_cookie('_currentUrl_'),'操作失败');
            put_msg('117');
    }
}
    //  public function actionUpdatecheck($id) {
    //     $modelName = $this->model;
    //     $model = $this->loadModel($id, $modelName);
    //     $data = array();
    //     if (!Yii::app()->request->isPostRequest) {
    //         $data['model'] = $model;
    //         $this->render('update_check', $data);
    //     } else {
    //         //$model->reasons_for_failure = $_POST['GfSite']['reasons_for_failure'];
    //         //$model->reasons_time = date('Y-m-d H:i:s');
    //         //$model->reasons_adminname = get_session('admin_name');
    //         //$model->reasons_gfaccount = get_session('gfaccount');
    //         put_msg('106');
    //        // put_msg($_POST['submitType']);
    //         //if($_POST['submitType'] == 'notpass') $model->site_state_name = '审核不通过1';
    //         show_status($model->save(),'操作成功',get_cookie('_currentUrl_'),'操作失败');
    //     }
    // }

    // public function actionUpdatecheck($id) {
    //     $modelName = $this->model;
    //     $model = $this->loadModel($id, $modelName);
    //     $data = array();
    //     if (!Yii::app()->request->isPostRequest) {
    //         $data['model'] = $model;
    //         $this->render('update_check', $data);
    //     } else {
    //         put_msg('102');
    //         put_msg($_POST['submitType']);
    //         if($_POST['submitType'] == 'notpass') {
    //             $model->state = 373;//'审核不通过';
    //              $model->state_name = '审核不通过';//'审核不通过';
    //         }
    //         if($_POST['submitType'] == 'pass') {
    //             $model->state = 372;//'审核通过';
    //             $model->state = '审核通过';//'审核通过';
    //             $model->createAdminUser();
    //         }
    //         $this->saveData($model,$_POST["$this->model"]);
    //     }
    // }

 
    public function actionUpdatefail($id) { 
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update_fail', $data);
        } else {
            put_msg($_POST['submitType'].'-------submit');
            if($_POST['submitType'] == 'again'){
                put_msg('again');
                $model->state = 371;//'待审核';
                 $model->state_name = '待审核';//'待审核';
                $model->reviewCom = '';
            }
            if($_POST['submitType'] == 'baocun'){
                $model->state = 373;
                $model->state_name = '审核不通过';
            };
            put_msg('180');
            $this->saveData($model,$_POST["$this->model"]);
        }
    }

    public function actionIndexpass($keywords='') {    
        $this->showIndex($keywords,'index_pass','审核通过',15);
    }

    public function actionPassdetail($id) { 
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        $data['model'] = $model;
        $this->render('pass_detail', $data);
    }

    //小程序注册
    public function actionWxCreate($club_name,$club_address,$contact_phone,$email){
        $model = new ClubListSqdw;
        $model->state = 371;
        $model->club_code=getAutoNo('ClubListSqdw');
        $model->club_name=$club_name;
        $model->club_address=$club_address;
        $model->contact_phone=$contact_phone;
        $model->email=$email;
        $model->save()?JsonSuccess():JsonFail();
    }

     //小程序接口 zx测试
    //单位列表 厨房信息
    
    public function actionWeChatGetclublist($id=0){
        // 构建查询条件
        $criteria = new CDbCriteria;
        $criteria->order = "id ASC";
        $criteria->addCondition("state = 372");
        if($id!=0) $criteria->addCondition("id = ".$id);
        // 查询所有的俱乐部列表
        $allClubList = ClubListSqdw::model()->findAll($criteria);

        // 过滤掉 id 为 2450 且 id 包含 3706 的项目
        $filteredClubList = array_filter($allClubList, function($club) {
            return $club->id != 2450;
        });

        // 对过滤后的结果进行编码并输出
        echo CJSON::encode($filteredClubList);
    }



 }