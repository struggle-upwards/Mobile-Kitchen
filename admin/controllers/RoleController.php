<?php

class RoleController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }
	
	public function actionGetClubAjax($type = '', $keywords = '') {
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $w1=get_like('1','club_code,club_name',$keywords);
        $criteria->condition=$w1;
        $criteria->limit = 500;
        $tmp = $model->findAll($criteria);
        $arr =toIoarray($tmp,'id,club_code,club_name,club_type_name');      
         $criteria = new CDbCriteria;
       if ($club_id<0) $club_id=get_session('club_id'); 
        $w1='lang_type='.$lang_type.(($lang_type=='0') ? '' : ' and club_id='.$club_id);  
        $criteria->condition=get_like($w1,'admin_gfaccount,admin_gfnick',$keywords,'');
        $criteria->order = 'admin_gfaccount';
        parent::_list($model, $criteria);
    }
  

    public function actionIndex($keywords = '',$f_tcode="",$club_id=-1) {
      set_cookie('_currentUrl_', Yii::app()->request->url);
      $modelName = $this->model;
      $model = $modelName::model();
      $criteria = new CDbCriteria;
      $wn=strlen($f_tcode);
      if ($club_id<0) $club_id=get_session('club_id');
      $w1="club_id=".$club_id;
      $w1=get_like($w1,'f_rname,f_rcode',$keywords);
      $criteria->condition=get_like($w1,"f_tcode",$f_tcode);
      $criteria->order = 'f_tcode';
      parent::_list($model, $criteria);
    }

    public function actionCreate() {   
      $this-> actionUpdate(0);
    }

  public function actionUpdate($f_id) {
    $modelName = $this->model;
    $model = new $modelName('create');
    if($f_id) $model = $this->loadModel($f_id, $modelName);
    if (!Yii::app()->request->isPostRequest) {
       $data = array();
       $data['model'] = $model;
       $data['model']->if_delete=$data['model']->f_opter;
       $data['model']->f_opter=explode(',',$data['model']->f_opter);
       $data['mainmenu']=MainMenu::model()->findAll('f_show=1 order by f_code');
       $this->render('update', $data);
    } else {
        $this-> saveData($model,$_POST[$modelName],1);
    }
  }

   function get_chose($p1,$p2,$pscode,$plist,$pmname){
    if(!empty($p2)){
    $da2=explode('|',$p2);
    foreach ($da2 as $c){
          foreach ($pmname as $c1){
                  if ($c==$c1['f_id']){
                      $pmname1=$c1['f_mname'];
                      $c5=0;
                      foreach ($plist as $c2){
    
                            if (($pmname1==$c2['f_name'])&&($pscode==$c2['f_opcode'])){
                              $p1.=(($p1) ? "," : '').$c2['f_id'];$c5=1;
                                break;
                             }
                        }
                      if($c5==1)   break;

                    }
            }
      }
    }
    return  $p1;
   }
    function get_opter() {
      $list = Role::model()->findAll("left(f_opter,1)=' '");
      $mn = Menu::model()->findAll();
      $menuidstr='';
      $modelName = $this->model;
      $i=0;
     foreach ($list as $da1){
      
        $menuidstr='';
        $menuidstr=$this->get_chose($menuidstr,$da1['if_state'],'shehe',$list1,$mn);
        $menuidstr=$this->get_chose($menuidstr,$da1['if_inster'],'creat',$list1,$mn);
        $menuidstr=$this->get_chose($menuidstr,$da1['if_update'],'update',$list1,$mn); 
        $menuidstr=$this->get_chose($menuidstr,$da1['if_select'],'index',$list1,$mn);
        $menuidstr=$this->get_chose($menuidstr,$da1["if_delete"],'delete',$list1,$mn);
        $model0 = Role::model()->find('f_id='.$da1['f_id']);
       $model0->f_opter='0';
       $model0->f_opter=$menuidstr;
       $model0->save();
       $i=$i+1;
       if($i>=15){
        break;
       }
        
      }
     return ;  
  }
  
 function saveData($model,$post,$new) {
    $model->attributes =$post;
    $b1="";$s1="";
    for($i=0;$i<100;$i++)
     {
        if(isset($post['opt'.$i])){
          $v2=$post['opt'.$i];
          if(!empty($v2))
          foreach ($v2 as $v1){
            if (!empty($v1)){
              $s1.=$b1.$v1; $b1=",";
             }
           }
        }
      }
  //  put_msg($s1);
    $model->f_opter= $s1;//$s1;
    $model->if_delete='';
    $st=$model->save();
    show_status($st,'保存成功', returnList(),'保存失败');  
  }

    public function actionDelete($id) {
        parent::_clear($id,'','f_id');
    }
}


