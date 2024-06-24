<?php

class OrderController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

    public function actionIndex($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = '1';
        if ($keywords !== '') {
            $criteria->condition.=' AND (id like "%' . $keywords . '%" OR order_id like "%' . $keywords . '%")';
        }
        $criteria->order = 'id ASC';
        parent::_list($model, $criteria);
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');   
        $data = array();
        parent::_create($model, 'create', $data, returnList());
    }


    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            
        }
        parent::_update($model, 'update', $data, returnList());
    }

    public function actionDelete($id) {
        // ajax_status(1, '删除成功');
        parent::_clear($id);
    }
	
	
	function saveData($model,$post) {
       $modelName = $this->model;
       $model->attributes = $_POST[$modelName];
		if ($_POST['submitType'] == 'shenhe') {
			$model->state = 371;
        } else if ($_POST['submitType'] == 'baocun') {
            $model->state = 721;
        } else if ($_POST['submitType'] == 'tongguo') {
            $model->state = 2;
        } else if ($_POST['submitType'] == 'butongguo') {
            $model->state = 373;
        } else {
            $model->state = 721;
        }
       $st=$model->save();
       $errors = array();
	  show_status($st,'保存成功', returnList(),'保存失败'); 
 	}

}
