<?php

class NationController extends BaseController {
    protected $model = '';
    public function init() {
        $this->model = 'Nation';
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

 public function actionDelete($id) {
      parent::_clear($id,'','id');
    }
    
  public function actionCreate() {   
       $this-> viewUpdate(0);
   } 

   public function actionUpdate($id) {
        $this-> viewUpdate($id);
    }/*曾老师保留部份，---结束*/
  
  public function viewUpdate($id=0) {
      $modelName = $this->model;
      $model = ($id==0) ? new $modelName('create') : $this->loadModel($id, $modelName);
      if (!Yii::app()->request->isPostRequest) {
         $data = array();
         $data['model'] = $model;
         $this->render('update', $data);
      } else {
         $this-> saveData($model,$_POST[$modelName]);
      }
  }/*曾老师保留部份，---结束*/
  
  function saveData($model,$post) {
       $model->attributes =$post;
       show_status($model->save(),'保存成功', returnList(),'保存失败');  
    }

    public function actionIndex( $keywords = '') {
        $criteria = new CDbCriteria;
        $criteria->condition=get_like('1','code,nation',$keywords,'');//get_where
        $criteria->order="id";//areaid,areaName
        $data = array();
        parent::display($this->model, $criteria, 'index', $data);
    }

}
