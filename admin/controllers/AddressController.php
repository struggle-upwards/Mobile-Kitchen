<?php

class AddressController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    public function actionIndex($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        // $criteria->condition =get_like('1','english_name,chinese_name',$keywords,'');
        $criteria->order = 'id ASC';
        parent::_list($model, $criteria);
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();

        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['province']='';
            $data['city']='';
            $data['district']='';
            $this->render('create', $data);
        } else {
            $this-> bsaveData($model,$_POST);
        }
    }

    function bsaveData($model,$post) {
       $model->attributes =$post;
       $model->attributes =$post['Address'];
       put_msg($post);
       $model->fullAddress = $post['province'].$post['city'].$post['district'].$post['Address']['ads_detail'];
       show_status($model->save(),'保存成功', returnList(),'保存失败');  
    }
    
    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();

        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['province']=$model->province;
            $data['city']=$model->city;
            $data['district']=$model->district;
            $this->render('update', $data);
        } else {
            $this-> bsaveData($model,$_POST);
        }
    }

    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_clear($id);
    }


    // 接口

    public function actionwxGetadslist($account='0',$id='0'){
        // 构建查询条件
        // put_msg('237');
        $criteria = new CDbCriteria;
        $criteria->order = "id ASC";
        // $criteria->addCondition("f_check = 2"); //通过
        if($account!='0') $criteria->addCondition("gf_account = ".$account);
        // 查询该单位的宴席列表,如果有传单位id的话
        if($id!='0') $criteria->addCondition("id = ".$id);
        // put_msg('242');
        $allClubList = Address::model()->findAll($criteria);
        // 对过滤后的结果进行编码并输出
        if($allClubList) $code=200; else $code=201;
        JsonSuccess($allClubList,$code);
    }

    public function actionwxbaocunaddress($addressId='0',$account='0',$name='',$phone='',$province='',$city='',$district='',$ads_detail='',$isDefault=''){
        $user=GfUser1::model()->find('GF_ACCOUNT="'.$account.'"');
        if(!empty($user)){
            $address = Address::model()->find('id='.$addressId);
            if(empty($address)){
                $address = new Address(); 
            }
            if(!empty($account))$address->gf_account = $account;
            if(!empty($name))$address->name = $name;
            if(!empty($phone))$address->phone = $phone;
            if(!empty($province))$address->province = $province;
            if(!empty($city))$address->city = $city;
            if(!empty($district))$address->district = $district;
            if(!empty($ads_detail))$address->ads_detail = $ads_detail;
            if(!empty($isDefault))$address->isDefault = $isDefault == 1;
            $address->fullAddress = $province.$city.$district.$ads_detail;
            //如果是默认地址，其余为非默认
            if($isDefault == 1){
                Address::model()->updateAll(array('isDefault' => 0), 'gf_account='.$account);
            }
            if($address->save()){
                // 保存成功
                $code=200;
                JsonSuccess($code);
            } else {
                // 保存失败，可以返回错误信息或者进行其他操作
                $sa = $address->save();
                put_msg($sa->errors);
                JsonFail('201');
            }
        } else {
            // 如果没有找到用户，可以返回错误信息或者进行其他操作
            JsonFail('系统出错，请联系管理员');
        }

    }


    public function actionwxDeleteads($id='0'){
        $address = Address::model()->find('id='.$id);
        if($address){
            parent::_clear($id);
            $code = 200;
            JsonSuccess($code);
        }else{
            JsonFail('系统出错，请联系管理员');            
        }
    }


    
    // //  城市选择
    // public function actionScales($info_id){
    //     $ws=array(
    //     'select'=>array('id','CODE','country_id','country_code','region_name_e','level','upper_region','region_name_c'),
    //     'order'=>'id', 'condition'=>'upper_region='.$info_id);
    //     $data = TRegion::model()->findAll($ws);
    //     if(!empty($data)){
    //         echo CJSON::encode($data);
    //     }
    // }
    // //  城市选择
    // public function actionSearch(){
    //     $level=$_POST['level'];
    //     $m=new TRegion(); 
    //     $w1='(region_name_c="'.$_POST['name'].'" and level='.$level.')';
    //     $id=$m->readValue($w1.' order by id ASC','id');
    //     if(!empty($id)){
    //         $tmp=$m->findAll('upper_region='.$tmp->id);
    //         $arr=toIoArray($tmp,'region_name_c');
    //         ajax_exit($arr);
    //     }
    // }

}
