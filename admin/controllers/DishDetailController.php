<?php

class DishDetailController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    public function actionDelete($id) {
      parent::_clear($id,'','id');
    }

    public function actionIndex($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        if(get_session('club_id') != 2450){
            $w1=" kitchen_id='".get_session('club_id')."'";
        }else{
            $w1= null;
        }
        $criteria->condition=get_like($w1,'dish_name',$keywords);
        $criteria->order = 'use_num DESC';  // 按使用次数降序排列
        $data = array(); 
        parent::_list($model, $criteria, 'index', $data);
    }

    public function actionCreate() {   
       $this-> viewUpdate(0);
    } 

    public function actionUpdate($id) {
        $this-> viewUpdate($id);
    }
  
    public function viewUpdate($id=0) {
        $modelName = $this->model;
        $model = ($id==0) ? new $modelName('create') : $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $data['model'] = $model;
           $data['flag'] = ($id==0) ? 0 : 1;    // 区分是添加还是编辑

           $this->render('update', $data);
        } else {
            if($id == 0) $model->use_num = 0;
           $this->saveData($model,$_POST[$modelName]);
        }
    }
  
    function saveData($model,$post) {
       $model->attributes =$post;
       $model->kitchen_id = get_session('club_id'); //保存厨房id
       $model->kitchen_code = get_session('club_code'); //保存厨房id
       show_status($model->save(),'保存成功', get_cookie('_currentUrl_'),'保存失败');  
    }

    // public function actionwxgetdishdetail($meal_id='0'){
    //     $meal = MealData::model()->find('id="'.$meal_id.'"');//找到对应的宴席
    //     $selectdish =json_decode(trim($meal->selected_dishes), true);
    //     if (is_array($selectdish)) {
    //         // 使用foreach循环遍历数组
    //         foreach ($selectdish as$dishid) {

    //         }
    //     }


    //     $modelName = $this->model;
    //     $modeldish = $modelName::model()->find('id="'.$id.'"');
    //     if(!empty($modeldish)){
    //         $res = $modeldish->getwxdishInfo();
    //     }
    //     if(empty($res)) $res=array();
    //     $code = empty($res['id'])?201:200;
    //     JsonSuccess($res,$code);
    // }

}