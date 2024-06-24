<?php

class swiperImageController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
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
                       if($fileSize<500000000){
                            $fileNameNew=uniqid('',true).".".$fileActualExt;
                            $fileDestination='uploads/image/'.$fileNameNew;
                            $fileDestination=$this->convertEncoding($fileDestination);
                            move_uploaded_file($fileTmpname, $fileDestination);
                            return $fileDestination;
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
    public function actionchangePosition(){
        $firId=$_POST['firId'];
        $secId=$_POST['changeId'];
        $fir=swiperImage::model()->find('id='.$firId);
        $sec=swiperImage::model()->find('id='.$secId);
        $temp=$fir->sortNumber;
        $fir->sortNumber=$sec->sortNumber;
        $sec->sortNumber=$temp;
        $fir->save();
        $sec->save();
    }
    public function actionUpdate(){
           $id=$_POST['id'];
           $num=swiperImage::model()->count();
           $updateImage=swiperImage::model()->find('id='.$id);
           $updateImage->imgURL=$this->UploadImg('file');
           $updateImage->save();
           echo CJSON::encode($updateImage);
    }   
    public function actionAdd(){
           $num=swiperImage::model()->count();
           $newImage=new swiperImage;
           $newImage->imgURL=$this->UploadImg('file');
           $newImage->sortNumber=swiperImage::model()->count()+1;
           $newImage->save();
           echo CJSON::encode($newImage);
    }
    public function actionGetImage(){
        $allImage=swiperImage::model()->findAll();
        echo CJSON::encode($allImage);
    }
    public function actionWeChatGetAllImage(){
        $criteria=new CDbCriteria;
        $criteria->order="sortNumber asc";
        $allImage=swiperImage::model()->findAll($criteria);
        echo CJSON::encode($allImage);
    }
    public function actionIndex(){
    set_cookie('_currentUrl_', Yii::app()->request->url);
    $modelName = $this->model;
    $model = $modelName::model();
    $criteria = new CDbCriteria;
    $criteria->order="sortNumber asc";
    $data = array();
    parent::_list($model, $criteria, 'index', $data);
    }
}
