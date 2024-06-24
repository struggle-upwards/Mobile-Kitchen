<?php

class DishDetailController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    function saveData($model,$post) {
        $model->attributes = $post;
        show_status($model->save(),'保存成功',get_cookie('_currentUrl_'),'保存失败');  
    }

    public function actionDelete($id) {
      parent::_clear($id,'','id');
    }

    public function actionIndex($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $w1=" kitchen_id='".get_session('club_id')."'";
        $criteria->condition=get_like($w1,'dish_name',$keywords);
        $criteria->order = 'use_num DESC';  // 按使用次数降序排列
        $data = array(); 
        parent::_list($model, $criteria, 'index', $data);
    }

    public function actionCreate() {   
       $this-> viewUpdate($id=0);
    } 

// public function actionCreate() {
//     $model = new DishDetail();
//     $data = array();
//     if (!Yii::app()->request->isPostRequest) {
//         put_msg('is not request isPostRequest');
//         $data['model'] = $model;
//         // $siteCode = setGetValue('siteCode',getAutoNo('DishDetail'));
//         // $data['siteCode'] = $siteCode;
//         // $data['sign'] = 'create';
//         $data['flag'] = 0;
//         $this->render('update', $data);
//     }else{
//         put_msg('else is request isPostRequest');
//         $sa = $model->save();
//         put_msg('515151515151');
//         if($sa){
//             put_msg('111111111111111111');
//         }
//         else{
//             put_msg('0000000000000000000000000000000000000000000000000000000000000000000000000000000');
//         }
//         // $model->state = 371;//审核中
//         // $model->state_name='待提交';
//         // $model->club_code = setGetValue('siteCode');
//         // $this->saveData($model,$_POST["$this->model"]);

//     }
// }
// public function actionCreate() {
//     $model = new DishDetail;
//     $data = array();
//     if (!Yii::app()->request->isPostRequest) {
//         put_msg('is not request isPostRequest');
//         $data['model'] = $model;
//         $this->render('update', $data);
//     }else{
//         put_msg('else is request isPostRequest');
//         $model->use_num = 0;//0次

//         $this->saveData($model,$_POST["$this->model"]);
//     }
// }

    public function actionUpdate($id) {
        $this-> viewUpdate($id);
    }
  
    public function viewUpdate($id=0) {
        if($id==0){
            put_msg('viewup');
            $model = new DishDetail();
        }else{
            $modelName = $this->model;
            $model = $this->loadModel($id, $modelName);
        }
        $data = array();
        // $modelName = $this->model;
        // $model = ($id==0) ? new DishDetail : $this->loadModel($id, $modelName);
        // if($id == 0){
        //     put_msg($modelName);
        //     put_msg('id=0');
        // }
        put_msg('45');
        if (!Yii::app()->request->isPostRequest) {
            put_msg('isnot');
           // $data = array();
           $data['model'] = $model;
           $data['flag'] = ($id==0) ? 0 : 1;    // 区分是添加还是编辑
           $this->render('update', $data);
        } else {
           put_msg('isunnot');
           // $model->attributes = $post;
           // $sa = $model->save();
           $this->saveData($model,$_POST["$this->model"]);
           put_msg('65---');

        }
    }
  

}