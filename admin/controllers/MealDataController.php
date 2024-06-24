<?php

class MealDataController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    public function actionDelete($id) {
      parent::_clear($id,'','id');
    }

    // 上架处理
    public function actionIndex($keywords = '',$state='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        // echo get_session('club_id');
        if(get_session('club_id')!=2450){  //不是平台要加访问厨房单位限制，只能看到自己单位的
            $w1=" kitchen_code='".get_session('club_id')."'";
        }else{
            $w1=null;
        }
        $w1= editCondition($w1,'f_check_name',$state);
        $criteria->condition=get_like($w1,'kitchen_name,meal_name',$keywords);
        $criteria->order = 'id DESC';
        $data = array(); 
        $data['state']= BaseCode::model()->getEditState();
        parent::_list($model, $criteria, 'index', $data);
    }

    // 上架处理-添加
    public function actionCreate() {   
       $this-> viewUpdate(0);
    } 

    // 上架处理-编辑
    public function actionUpdate($id) {
        $this-> viewUpdate($id);
    }

    public function viewUpdate($id=0,$formData="") {
        $modelName = $this->model;
        $model = ($id==0) ? new $modelName('create') : $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $data['model'] = $model;
           $mealkit_id = ($id==0) ? get_session('club_id') : $model->kitchen_code;
           $data['kitchen_code'] = $mealkit_id;
           $data['kitchen_name'] = ($id==0) ? get_session('club_name') : $model->kitchen_name;
           $data['dishes'] = DishDetail::model()->findAll('kitchen_id='.$mealkit_id);
           $data['meal_type'] = MealType::model()->findAll(['select' => 'meal_type_name']);
           put_msg($data['meal_type']);
           $data['flag'] = ($id==0) ? 0 : 1;    // 区分是添加还是编辑
           $this->render('update', $data);
        } else {
            if($_POST['submitType'] == 'tijiao'){
                $model->f_check=371;
                $model->f_check_name='待审核';
            }
            if($id==0){ //创建
                $model->f_check=371;
                $model->f_check_name='待审核';
                $model->kitchen_code = get_session('club_id');
                $model->kitchen_name = get_session('club_name');
                $model->save();
            }
            // $model->kitchen_code = get_session('club_id');
            // $model->kitchen_name = get_session('club_name');
           $this->bsaveData($model,$_POST[$modelName]);
        }
    }

    // 上架审核-待审核
    public function actionIndexcheck($keywords = '') {
       $this->ShowCheck($keywords,'indexcheck','待审核');
    }

    // 上架审核-详情审核
    public function actionUpdatecheck($id) {
        $modelName = $this->model;
        $model = ($id==0) ? new $modelName('create') : $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $data['model'] = $model;
           $data['dishes'] = MealDetail::model()->findAll('meal_id='.$model->id);
           $this->render('updatecheck', $data);
        } else {
           $this->saveCheck($model);
        }
    }

    // 审核情况查看
    public function actionUpdatesee($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
       $data = array();
       $data['model'] = $model;
       $data['dishes'] = MealDetail::model()->findAll('meal_id='.$model->id);
       $this->render('updatesee', $data);
    }

    // 上架调整
    public function actionIndexsale($keywords = '') {
       $this->ShowCheck($keywords,'indexsale','通过');
    }

    // 上下架切换
    public function actionUpdateIndexsale($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $model->onsale=($model->onsale+1)%2;    // 0下架 1上架 切换
               if($model->save()){
            ajax_status(1, '保存成功！');
       }
        // show_status($model->save(),'切换成功', get_cookie('_currentUrl_'),'切换失败');
        // $model->save();
        // $this->ShowCheck('','indexsale','通过');
    }

    // 已上架列表
    public function actionIndexsale_already($keywords = '') {
       set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $w1=" kitchen_code='".get_session('club_id')."'";
        $w1.=" and onsale=1";
        $w1= editCondition($w1,'f_check_name','通过');
        $cr=get_like($w1,'kitchen_name,meal_name',$keywords,'');
        $criteria = new CDbCriteria;
        $criteria->condition=$cr;
        $criteria->order = 'id DESC';
        $data = array();
        parent::_list($model, $criteria, 'indexsale_already', $data);
    }

    public function ShowCheck($keywords,$viewfile,$f_check_name) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        if(get_session('club_id')!=2450){  //不是平台要加访问厨房单位限制，只能看到自己单位的
            $w1=" kitchen_code='".get_session('club_id')."'";
        }else{
            $w1=null;
        }
        $w1= editCondition($w1,'f_check_name',$f_check_name);
        $cr=get_like($w1,'kitchen_name,meal_name',$keywords,'');
        $criteria = new CDbCriteria;
        $criteria->condition=$cr;
        $criteria->order = 'id DESC';
        $data = array();
        parent::_list($model, $criteria, $viewfile, $data);
    }

  
  function bsaveData($model,$post) {
       $model->attributes =$post;
       show_status($model->save(),'保存成功', returnList(),'保存失败');  
    }
    
public function actionCheck($id=0) {

    $modelName = $this->model;
    $model=$this->loadModel($id, $modelName);
    if($id==0) $model = new $modelName('create');//如果没有传入id，默认是创建
    if (!Yii::app()->request->isPostRequest) {
        $data = array();
        $model->initdata();
        $data['model'] = $model;
        $this->render('update_check', $data);
    } else {
        $post=$_POST['MallPriceSet'];
        setcheckName($model,'f_check,f_check_name',$_POST['submitType']);
        $model->reasons_for_failure=$post['reasons_for_failure'];
        $s1=$model->save();
        $w1='set_id='.$model->id;
        $sta=array('f_check'=>$model->f_check);
        show_status($s1,'审核成功',get_cookie('_currentUrl_'),'审核失败');
      }
    }
public function actionCheckOnly($id) {
    $modelName = $this->model;
    $model=$this->loadModel($id, $modelName);
    if (!Yii::app()->request->isPostRequest) {
        $data = array();
        $model->initdata();
        $data['model'] = $model;
        $this->render('check_only', $data);
    } else {
        $post=$_POST['MallPriceSet'];
        setcheckName($model,'f_check,f_check_name',$_POST['submitType']);
        $model->reasons_for_failure=$post['reasons_for_failure'];
        $s1=$model->save();
        $w1='set_id='.$model->id;
        $sta=array('f_check'=>$model->f_check);
        show_status($s1,'审核成功',get_cookie('_currentUrl_'),'审核失败');
      }
    }
    

    function saveData($model,$post) {
        put_msg($post);
        $model->attributes =$post;
        $model->pricing_type=361;
        $model->f_check =get_check_code($_POST['submitType']);
        if($_POST['submitType']=='shenhe') $model->apply_time=date('Y-m-d h:i:s');
        $sv=$model->save();
        MallPriceSetDetails::model()->updateAll(array('f_check'=>$model->f_check ),'set_id='.$model->id.' AND flash_sale=1');
        MallPricingDetails::model()->updateAll(array('f_check'=>$model->f_check ),'set_id='.$model->id.' AND flash_sale=1');
        $this->save_mall_price_set_details($model->id,$model->mall_member_price_id,$post['product']);
        if($_POST['submitType']=='shenhe'){
           $action=get_cookie('_currentUrl_');
           $s='提交成功';$f='提交失败';
        } else {
            $action=$this->createUrl('update_supplier', array('id'=>$model->id));
            $s='保存成功';$f='保存失败';
        }
        show_status($sv,$s, $action,$f);
    }


    // 审核保存
    function saveCheck($model) {
        // 表单中可修改的部分仅仅为 reasons_for_failure
        $model->reasons_for_failure=$_POST['MealData']['reasons_for_failure'];
        // 设置审核相关信息
        $model->reasons_adminID=get_session('gfaccount');
        $model->reasons_admin_nick=get_session('gfnick');
        $model->reasons_time=date('Y-m-d h:i:s');
        // 设置审核状态码和审核状态
        setcheckName($model,'f_check,f_check_name',$_POST['submitType']);
        show_status($model->save(),'操作成功', get_cookie('_currentUrl_'),'操作失败');
    }
    
    
    public function actionRefresh($id){
        $modelName = $this->model;
        $model = $this->loadModel($id,$modelName);
        $model->data_sourcer_bz = $model->data_sourcer_bz+1;
        $sv=$model->save();
        show_status($sv,'刷新成功',Yii::app()->request->urlReferrer,'刷新失败');
    }

    //小程序接口 zx测试
    public function actionwxCategoryList(){
        $types = MealType::model()->findAll(['select' => 'meal_type_name']);
        foreach ($types as$type) {
            $criteria = new CDbCriteria;
            $criteria->order = "id ASC";
            $criteria->addCondition("f_check = 2"); //通过
            $criteria->addCondition('meal_type="'.trim($type->meal_type_name).'"');
            $categoryData = MealData::model()->findAll($criteria);
            $data[] = array(
                'category' => $type->meal_type_name,
                'data' => $categoryData
            );
            // $data[$type->meal_type_name] = MealData::model()->findAll('meal_type="'.trim($type->meal_type_name).'"');
        }
        echo CJSON::encode($data);
    }

    public function actionwxGetMeallist($id=0,$typemeal='无'){
        // 构建查询条件
        // put_msg('237');
        $criteria = new CDbCriteria;
        $criteria->order = "id ASC";
        $criteria->addCondition("f_check = 2"); //通过
        if($id!=0) $criteria->addCondition("kitchen_code = ".$id);
        if($typemeal!='无') $criteria->addCondition('meal_type="'.trim($typemeal).'"');
        // 查询该单位的宴席列表,如果有传单位id的话
        // put_msg('242');
        $allClubList = MealData::model()->findAll($criteria);
        // // 过滤掉 id 为 2450 且 id 包含 3706 的项目
        // $filteredClubList = array_filter($allClubList, function($club) {
        //     return $club->id != 2450;
        // });
        // 对过滤后的结果进行编码并输出
        echo CJSON::encode($allClubList);
    }
    // //传宴席id，直接返回数据
    public function actionwxgetdishdetail($meal_id='0'){
        $modelName = $this->model;
        $meal = $modelName::model()->find('id="'.$meal_id.'"');//找到对应的宴席
        $selectdish =json_decode(trim($meal->selected_dishes), true);
        // $selectdish = $meal->selected_dishes;
        // echo $selectdish;
        // foreach ($selectdish as$dishid) {  
        //     echo $dishid;
        // }
        $dishes = array();
        if (is_array($selectdish)) {
            // 使用foreach循环遍历数组
            foreach ($selectdish as$dishid) {
                $dish = DishDetail::model()->find('id='.$dishid);
                if ($dish !== null) {
                    // 将查询到的$dish模型添加到$dishes数组中
                    $dishes[] =$dish;
                }
            }
        }
        $data=array();
        $data['meal']=$meal;
        $data['dishes']=$dishes;
        echo CJSON::encode($data);
    }
}
 