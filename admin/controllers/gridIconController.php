<?php

class gridIconController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }
    public function convertEncoding($string){
    //根据系统进行配置
    $encode = stristr(PHP_OS, 'WIN') ? 'GBK' : 'UTF-8';
    $string = iconv('UTF-8', $encode, $string);
    //$string = mb_convert_encoding($string, $encode, 'UTF-8');
    return $string;
    }

    public function UploadImg($s){
            if(isset($_FILES[$s]['name'])){
                  $fileName=$_FILES[$s]['name'];
                  $fileTmpname=$_FILES[$s]['tmp_name'];
                  $fileSize=$_FILES[$s]['size'];
                  $fileError=$_FILES[$s]['error'];
                  $filenType=$_FILES[$s]['type'];
                   $fileExt=explode('.',$fileName);//文件类型
                   $fileActualExt=strtolower(end($fileExt)); 
                   $allowed=array('jpg','jpeg','png');
                   if(in_array($fileActualExt,$allowed)){
                    if($fileError===0){
                       if($fileSize<5000000){
                            $fileNameNew=uniqid('',true).".".$fileActualExt;
                            $fileDestination='uploads/indexIcon/'.$fileNameNew;
                            $fileDestination=$this->convertEncoding($fileDestination);
                            move_uploaded_file($fileTmpname, $fileDestination);
                            return '/'.$fileDestination;
                       }else{
                          //过大
                          return;
                       }
                    }else{
                        //错误
                          return;
                    }
                   }else{
                    //格式不对
                    return;
                   }
            }else{
                return "";
            }
    }
    public function actionUpdate(){
        $id=$_POST['hidId'];
        $curIcon=gridIcon::model()->find('id='.$id);
        $curIcon->iconURL=$this->UploadImg('hidFile');
        if(isset($_POST['updateTitle'])&&$_POST['updateTitle']!="")
            $curIcon->title=$_POST['updateTitle'];
        $curIcon->save();
    }
    public function actionDelete() {
        $id=$_POST['id'];
        parent::_clear($id);
        $criteria=new CDbCriteria;
        $criteria->order="sortNumber asc";
        $allImage=swiperImage::model()->findAll($criteria);
        for($i=0;$i<count($allImage);$i++){
            $allImage[$i]->sortNumber=$i;
            $allImage[$i]->save();
        }
    }
    public function actionChangeShow(){
       $id=$_POST['id'];
       $tempIcon=gridIcon::model()->find('id='.$id);
       if($tempIcon->isShow==0)
          $tempIcon->isShow=1;
       else
          $tempIcon->isShow=0;
      $tempIcon->save();
    }
    public function actionchangePosition(){
        $firId=$_POST['firId'];
        $secId=$_POST['changeId'];
        $fir=gridIcon::model()->find('id='.$firId);
        $sec=gridIcon::model()->find('id='.$secId);
        $temp=$fir->sortNumber;
        $fir->sortNumber=$sec->sortNumber;
        $sec->sortNumber=$temp;
        $fir->save();
        $sec->save();
    }

    public function actionGetImage(){
        $allImage=gridIcon::model()->findAll();
        echo CJSON::encode($allImage);
    }
    public function actionWeChatGetAllIcon(){
        $criteria=new CDbCriteria;
        $criteria->order="sortNumber asc";
        $allIcon=gridIcon::model()->findAll($criteria);
        echo CJSON::encode($allIcon);
    }
    public function actionIndex(){
    set_cookie('_currentUrl_', Yii::app()->request->url);
    $modelName = $this->model;
    $model = $modelName::model();
    $criteria = new CDbCriteria;
    $criteria->order="sortNumber asc";
    // $criteria->condition = get_like('ct_condition="未提交审核"','ct_name,ct_connector_name',$keywords,'');
    // $criteria->order = 'ct_update_time desc';
    $data = array();
    parent::_list($model, $criteria, 'index', $data);
    }
}
