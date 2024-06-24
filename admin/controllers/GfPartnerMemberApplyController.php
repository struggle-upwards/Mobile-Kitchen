<?php

class GfPartnerMemberApplyController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }
    public function actionIndex_apply($type='' , $start_date = '', $end_date = '', $keywords = '',$state=0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        // $model->updateAll(array('auth_state'=>929),'!isNull(relieve_time) and relieve_time<"'.date('Y-m-d H:i:s').'" and auth_state<>929');
        // $criteria->condition = 'partner_id='.get_session('club_id').' and state='.$state;
        // $criteria->condition=get_where($criteria->condition,!empty($type),'type',$type,'');
        // $criteria->condition=get_where($criteria->condition,($start_date!=""),'apply_time>=',$start_date,'"');
        // $criteria->condition=get_where($criteria->condition,($end_date!=""),'apply_time<=',$end_date,'"');
        if(get_session('club_id')!=2450) $criteria->condition = 'apply_club_id='.get_session('club_id');
		$criteria->condition = get_like($criteria->condition,'code,zsxm,gf_account',$keywords,'');
        $criteria->order = 'id DESC';
        $data = array();
        parent::_list($model, $criteria, 'index_apply', $data);
    }

    public function actionIndex($keywords = '',$auth_state='',$state='',$type='',$effective_start_time='',$effective_end_time='',$is_excel='', $index='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $model->updateAll(array('auth_state'=>1473),'!isNull(relieve_time) and relieve_time<"'.date('Y-m-d H:i:s').'"');
        $criteria->condition = 'partner_id='.get_session('club_id');
        if($index==5){
            $criteria->condition.=' and state in(371) and auth_state=929 and partner_id='.get_session('club_id');
        }elseif($index==1){
            $criteria->condition.=' and state in(2,373)';
            $effective_start_time=empty($effective_start_time) ? date("Y-m-d") : $effective_start_time;
            $effective_end_time=empty($effective_end_time) ? date("Y-m-d") : $effective_end_time;
        }else if($index==2){
            $criteria->condition.=' and state in(373,374)';
        }else if($index==3){
            $criteria->condition.=' and state in(2) and  auth_state in(931,1484,1485) and partner_id='.get_session('club_id');
        }else if($index==4){
            $criteria->condition.=' and state in(2) and !isNull(relieve_time)';
        }else{
            $effective_start_time='';$effective_end_time='';
        }
        $criteria->condition.=' and type='.$type;
        // $criteria->condition=get_where($criteria->condition,!empty($type),'type',$type,'');
        $criteria->condition=get_where($criteria->condition,!empty($state),'state',$state,'');
        $criteria->condition=get_where($criteria->condition,!empty($auth_state),'auth_state',$auth_state,'');
        if($index==1){
            $criteria->condition .=' and left(t.check_time,10)>="'.$effective_start_time.'"';
            $criteria->condition .=' and left(t.check_time,10)<="'.$effective_end_time.'"';
        }elseif($index==3){
            $criteria->condition=get_where($criteria->condition,($effective_start_time!=""),'left(t.update,10)>=',$effective_start_time,'"');
            $criteria->condition=get_where($criteria->condition,($effective_start_time!=""),'left(t.update,10)<=',$effective_end_time,'"');
        }elseif($index==4){
            $criteria->condition=get_where($criteria->condition,($effective_start_time!=""),'left(t.relieve_time,10)>=',$effective_start_time,'"');
            $criteria->condition=get_where($criteria->condition,($effective_start_time!=""),'left(t.relieve_time,10)<=',$effective_end_time,'"');
        }else{
            $criteria->condition=get_where($criteria->condition,($effective_start_time!=""),'left(t.apply_time,10)>=',$effective_start_time,'"');
            $criteria->condition=get_where($criteria->condition,($effective_start_time!=""),'left(t.apply_time,10)<=',$effective_end_time,'"');
        }
        $criteria->condition=get_like($criteria->condition,'code,zsxm,partner_name',$keywords,'');//get_where
        $criteria->order = 'id DESC';
        $data = array();
        $data['type'] = BaseCode::model()->getCode(402);
        $data['project_list'] = ProjectList::model()->getProject();
        $data['count1'] = $model->count('partner_id='.get_session('club_id').' and state=371 and auth_state=929 and type='.$type);
        $data['time_start'] = $effective_start_time;
        $data['time_end'] = $effective_end_time;
		if(!isset($is_excel) || $is_excel!='1'){
            parent::_list($model, $criteria, 'index', $data);
		}else{
		    $arclist = $model->findAll($criteria);
		    $data=array();
            $title=array();
            if($index==3&&$type==403){
                $titlefiled = array(
                    'code',
                    'gf_account',
                    'zsxm',
                    'sex',
                    'native',
                    'apply_phone',
                    'project_name',
                    'state_name',
                    'effective_start_time'
                );
            }
            foreach ($titlefiled as $fv) {
                array_push($title, $model->getAttributeLabel($fv));
		    }
            array_push($data, $title);
		    foreach ($arclist as $v) {
		        $item = array();
		        foreach ($titlefiled as $fv) {
		            $s = '';
		            if ($fv == 'base_code_type') {
		                $s = $v->base_code_type->F_NAME;
		            } elseif ($fv == 'base_code_state') {
		                $s = $v->base_code_state->F_NAME;
		            } else {
		                $s = $v->$fv;
		            }
		            array_push($item, $s);
		        }
		        array_push($data, $item);
		    }
		    parent::_excel($data,'个人成员列表.xls');
		}
    }
    
    public function actionUpExcel($info='',$club_id='',$logon_way=1460){
        if($club_id==''){
            $club_id=get_session('club_id');
        }
        if(isset($_POST['submit'])){
            $attach = CUploadedFile::getInstanceByName('excel_file');
            $sv = 0;
            $info = '';
            if(!empty($attach)){
                if ($attach->getType()=='application/vnd.ms-excel' || $attach->getType()=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                    if($attach->size > 2*1024*1024){
                        $info = "提示：文件大小不能超过2M";  
                    }
                    else{
                        // 获取文件名
                        $excelFile = $attach->getTempName();
                        $extension = $attach->extensionName ;
                        Yii::$enableIncludePath = false;
                        Yii::import('application.extensions.PHPExcel.PHPExcel', 1);
                        $phpexcel = new PHPExcel;
                        if ($extension=='xls') {
                            $excelReader = PHPExcel_IOFactory::createReader('Excel5');
                        } else {
                            $excelReader = PHPExcel_IOFactory::createReader('Excel2007');
                        }
                        $objPHPExcel = $excelReader->load($excelFile);//
                        $sheet = $objPHPExcel->getSheet(0);
                        $highestRow = $sheet->getHighestRow(); // 取得总行数
                        // $highestColumn = $sheet->getHighestColumn(); // 取得总列数
                        if($highestRow>202){
                            $info = "<br>提示：一次导入信息数据最多为200条。";
                        }else{ //检测数据是否符合要求
                            $pj='';
                            for ($row = 2; $row <= $highestRow; $row++){
                                $project_name = $sheet->getCell('B'.$row)->getValue();  // 项目
                                $zsxm = $sheet->getCell('D'.$row)->getValue();  // 姓名
                                $sex = $sheet->getCell('E'.$row)->getValue();  // 性别
                                $native = $sheet->getCell('F'.$row)->getValue();  // 籍贯
                                $nation = $sheet->getCell('G'.$row)->getValue();  // 民族
                                $birthdate = $sheet->getCell('H'.$row)->getValue();  // 出生年月
                                $id_card = $sheet->getCell('I'.$row)->getValue();  // 身份证号
                                if(strlen($project_name)>0&&strlen($zsxm)>0&&strlen($sex)>0&&strlen($native)>0&&strlen($nation)>0&&strlen($birthdate)>0&&strlen($id_card)>0){
                                    $le=['B','D','E','F','G','H','I'];
                                    foreach ($le as $l) {
                                        $content=$sheet->getCell($l.$row)->getValue();
                                        if (strlen($content)==0||strlen($content)>120) {
                                        $info = '<br>提示：第'.$l.'列数据不符合要求。内容不能为空，内容长度不能大于120。';
                                            break;
                                        }
                                    }
                                    $p_count=ClubProject::model()->count('state=372 and auth_state=461 and club_id='.$club_id.' and project_name="'.$project_name.'"');
                                    if($p_count<=0){
                                        $pj.=($pj==''?'':',').$project_name;
                                    }
                                }
                            }
                            if($pj!=''){
                                $info = '<br>该单位不存在'.$pj.'项目'.$info;
                            }
                        }//检测数据是否符合要求
                        if($info!=''){
                            $info='<span class="red">导入失败</span>'.$info.'<br>请删除错误数据，重新导入。';
                        }
                        if($info==''){
                            $modelName = $this->model;
                            $model = new $modelName;
                            $sa = 0;
                            $sc = 0;
                            for($row=2;$row<=$highestRow;$row++){
                                $project_name = $sheet->getCell('B'.$row)->getValue();  // 项目
                                $code = $sheet->getCell('C'.$row)->getValue();  // 会员编号
                                $zsxm = $sheet->getCell('D'.$row)->getValue();  // 姓名
                                $sex = $sheet->getCell('E'.$row)->getValue();  // 性别
                                $native = $sheet->getCell('F'.$row)->getValue();  // 籍贯
                                $nation = $sheet->getCell('G'.$row)->getValue();  // 民族
                                $birthdate = $sheet->getCell('H'.$row)->getValue();  // 出生年月
                                $id_card = $sheet->getCell('I'.$row)->getValue();  // 身份证号
                                $apply_phone = $sheet->getCell('J'.$row)->getValue();  // 联系电话
                                $apply_email = $sheet->getCell('K'.$row)->getValue();  //电子邮箱

                                if(strlen($project_name)>0||strlen($zsxm)>0||strlen($sex)>0||strlen($native)>0||strlen($nation)>0||strlen($birthdate)>0||strlen($id_card)>0){
                                    $club=ClubList::model()->find('id='.$club_id);
                                    $project=ProjectList::model()->find('project_type=1 and project_name="'.$project_name.'"');

                                        $import = new ClubMemberImportfile();
                                        $import->isNewRecord = true;
                                        unset($import->id);
                                        $import->club_type=189;
                                        // $import->import_id=$model2->id;
                                        $import->import_code=$code;
                                        $import->club_id=$club->id;
                                        // $import->gfid=$model2->gfid;
                                        // $import->gf_account=$model2->gf_account;
                                        $import->zsxm=$zsxm;
                                        $import->phone=$apply_phone;
                                        $import->email=$apply_email;
                                        $import->id_card=trim($id_card);
                                        $import->sex=$sex;
                                        $import->native=$native;
                                        $import->nation=$nation;
                                        $import->real_birthday=$birthdate;
                                        $import->project_id=$project->id;
                                        $import->logon_way=$logon_way;
                                        $si = $import->save();

                                    // 导入成员时的未成为学员的会员同时要成为GF俱乐部的学员
                                    $memberClub=2810;
                                    if($_SERVER['SERVER_NAME']=='qmdd.gf41.net'){
                                        $memberClub=2810;
                                    }else if($_SERVER['SERVER_NAME']=='qmdd.gfinter.net'){
                                        $memberClub=2512;
                                    }else if($_SERVER['SERVER_NAME']=='oss.gfinter.net'){
                                        $memberClub=2512;
                                    }
                                    $import2=ClubMemberList::model()->find('!isnull(club_id) and member_project_id="'.$project->id.'" and id_card_type=843 and id_card="'.trim($id_card).'"');
                                    if(empty($import2)){
                                        $import2 = new ClubMemberImportfile();
                                        $import2->isNewRecord = true;
                                        unset($import2->id);
                                        $import2->club_type=8;
                                        $import2->club_id=$memberClub;
                                        $import2->zsxm=$zsxm;
                                        $import2->phone=$apply_phone;
                                        $import2->email=$apply_email;
                                        $import2->id_card=trim($id_card);
                                        $import2->sex=$sex;
                                        $import2->native=$native;
                                        $import2->nation=$nation;
                                        $import2->real_birthday=$birthdate;
                                        $import2->project_id=$project->id;
                                        $import2->logon_way=$logon_way;
                                        $sm = $import2->save();
                                    }else{
                                        $sm = 1;
                                    }
                                    
                                }
                            }
                            if($si==1 && $sm==1){
                                $info = '导入完成';
                                $sv=1;
                            }
                            else{
                                $info = '导入失败';
                            }
                        }
                    }
                }
            }else{
                $info = "请先上传需要导入的成员Excel文档"; 
            }
        }
        return $this->render('upExcel',array('info'=>$info));
    }

    public function actionIndex_club($keywords = '',$auth_state='',$state='',$type='',$effective_start_time='',$effective_end_time='', $index='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $model->updateAll(array('auth_state'=>1473),'!isNull(relieve_time) and relieve_time<"'.date('Y-m-d H:i:s').'"');
        $criteria->condition='partner_id='.get_session('club_id');
        if($index==1){
            $criteria->condition.=' and state=2 and auth_state in(931,1484,1485)';
        }else if($index==2){
            $criteria->condition.=' and state in(373,374)';
        }else if($index==3){
            $criteria->condition.=' and state=371 and auth_state in(929,1483)';
        }else if($index==4){
            $criteria->condition.=' and state in(2) and !isNull(relieve_time)';
        }
        $criteria->condition.=' and type='.$type;
        // $criteria->condition=get_where($criteria->condition,!empty($type),'type',$type,'');
        $criteria->condition=get_where($criteria->condition,!empty($state),'state',$state,'');
		$criteria->condition=get_where($criteria->condition,!empty($auth_state),'auth_state',$auth_state,'');
        $criteria->condition=get_where($criteria->condition,($effective_start_time!=""),'t.entry_validity>=',$effective_start_time,'"');
        $criteria->condition=get_where($criteria->condition,($effective_start_time!=""),'t.entry_validity<=',$effective_end_time,'"');
        $criteria->condition=get_like($criteria->condition,'code,zsxm,partner_name',$keywords,'');//get_where
        $criteria->order = 'id DESC';
        $data = array();
        $data['type'] = BaseCode::model()->getCode(402);
        $data['project_list'] = ProjectList::model()->getProject();
        parent::_list($model, $criteria, 'index_club', $data);
    }

    public function actionIndex_query($keywords = '',$type='',$effective_start_time='',$effective_end_time='',$is_excel='', $index='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $model->updateAll(array('auth_state'=>1473),'!isNull(relieve_time) and relieve_time<"'.date('Y-m-d H:i:s').'"');
        $criteria->condition=get_where_club_project('partner_id','').' and state=2 and type='.$type.' and auth_state=931';
        $criteria->condition=get_where($criteria->condition,($effective_start_time!=""),'t.update>=',$effective_start_time,'"');
        $criteria->condition=get_where($criteria->condition,($effective_start_time!=""),'t.update<=',$effective_end_time,'"');
        $criteria->condition=get_like($criteria->condition,'code,zsxm,partner_name,project_name',$keywords,'');//get_where
        $criteria->order = 'id DESC';
        $data = array();
        $data['type'] = BaseCode::model()->getCode(402);
        $data['project_list'] = ProjectList::model()->getProject();
        parent::_list($model, $criteria, 'index_query', $data);
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            // $data['type'] = '404';
            $this->render('create', $data);
        } else {
            // if()  写一个判断，如果是已绑定，则不能进行申请
            $modelapply = $modelName::model()->find("gf_account=".$_POST[$modelName]['gf_account']);
            put_msg('111');
            if(!empty($modelapply)){
                if( $modelapply->auth_state==931)
                    ajax_status(0, '该会员已有绑定单位，申请失败！');
                else if($modelapply->auth_state==929){
                    ajax_status(0, '该会员申请正在审核中，请耐心等待！');
                }
                return ;
            }
            put_msg('222');
            $this->bsaveData($model,$_POST[$modelName]);
        }
    }

    public function actionIndex_check($type='', $start_date = '', $end_date = '', $keywords = '',$state=0) {
        $this->showIndex($type,$start_date,$end_date,$keywords,$state,'index_check','待审核');
    }
    public function actionIndex_fail($type='', $start_date = '', $end_date = '', $keywords = '',$state=0) {
        $this->showIndex($type,$start_date,$end_date,$keywords,$state,'index_fail','未通过');
    }
    
    public function showIndex($type='', $start_date = '', $end_date = '', $keywords = '',$state=0, $view='',$sname=''){
                set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        // $model->updateAll(array('auth_state'=>929),'!isNull(relieve_time) and relieve_time<"'.date('Y-m-d H:i:s').'" and auth_state<>929');
        // $criteria->condition = 'partner_id='.get_session('club_id').' and state='.$state;
        // $criteria->condition=get_where($criteria->condition,!empty($type),'type',$type,'');
        $clubid= get_session('club_id');
        if($clubid==2450){
           $criteria->condition .= 'state_name = "'.$sname.'" ';
        }else{
            $criteria->condition.='apply_club_id='.get_session('club_id').' and state_name = "'.$sname.'" ';
        }
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'apply_time>=',$start_date,'"');
        $criteria->condition=get_where($criteria->condition,($end_date!=""),'apply_time<=',$end_date,'"');
        $criteria->condition=get_like($criteria->condition,'code,zsxm,gf_account',$keywords,'');
        $criteria->order = 'id DESC';
        $data = array();
        parent::_list($model, $criteria, $view, $data);
    }

    public function actionUpdatecheck($id){
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update_check', $data);
        }else{
                put_msg($_POST['submitType']);
                if($_POST['submitType'] == 'notpass') {
                    put_msg('notpass');
                    $model->auth_state = 928;// 已绑定
                     $model->auth_state_name = '资料填写';// 已绑定
                     $model->state = 373;//'审核不通过';
                     $model->state_name = '未通过';//'审核不通过';
                    $sc=1;
                }
                if($_POST['submitType'] == 'pass') {
                   $model->state = 372;//'审核通过';
                   $model->state_name = '通过';//'审核通过';
                    $model->auth_state = 931;// 已绑定
                     $model->auth_state_name = '已绑定';// 已绑定
                    //审核通过需要将数据写入到clubmemberlist 和 gfuser1表
                    $sc = $this->checkpass($id);
                }
                $s1 = $model->save();
                show_status($model->save(),'操作成功',get_cookie('_currentUrl_'),'操作失败');
                put_msg('117');
        }
    }


    function bsaveData($model,$post) {
       $model->attributes =$post;
       put_msg(get_session('club_code'));
       // put_msg(ClubListSqdw::model()->find('club_code="'.$post['apply_club_code'].'"')->id);
       $model->apply_club_id = ClubListSqdw::model()->find('club_code="'.$post['apply_club_code'].'"')->id;
      // put_msg(ClubListSqdw::model()->find('club_code='.$post['apply_club_code'])->id);
       
       if($model->state=371)  $model->state_name='待审核';
       if($model->auth_state=929)  $model->auth_state_name='待审核';
       if($model->type==1720) $model->type_name='厨师';
       else if($model->type==1721) $model->type_name='普通用户';
       show_status($model->save(),'保存成功', returnList(),'保存失败');  
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update', $data);
        } else {
            $this->bsaveData($model,$_POST[$modelName]);
        }
    }


    function checkpass($id){
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        //先更新gfuser1表
        put_msg($id.'ckid');
         $gfUser=GfUser1::model()->find('GF_ACCOUNT="'.trim($model->gf_account).'"');
         put_msg($model->gf_account.'gf_acouunt');
         put_msg($gfUser->GF_ID.'gfidgfid');
         if(!empty($gfUser)){
            $gfUser->ZSXM = $model->zsxm;
            $gfUser->id_card_type = 843;
            $gfUser->id_card = $model->id_card;
            $gfUser->PHONE = $model->apply_phone;
            $gfUser->valid_date = $model->update;
            $gfUser->user_type = $model->type_name;
            $gfUser->passed = 372;
            $gfUser->passed_name = '已认证';
            //图片保存
         }
         $sa = $gfUser->save();
         //保存至club_member_list
         put_msg($model->gf_account);
         $model2=ClubMemberList::model()->find('gf_account="'.trim($model->gf_account).'"');
         // put_msg($model2->id.'model2account');
         //判断是否为新申请的账号
         if(empty($model2)){
            put_msg('新申请的账号');
            $model2 = new ClubMemberList();
            unset($model2->id);
         };
         put_msg('446');
         $model2->gf_account = $model->gf_account;
         $model2->save();
         $model2->club_name = $model->apply_club_name;
         $club_model = ClubListSqdw::model()->find('club_code="'.trim($model->apply_club_code).'"');
         $model2->gfpm_apply_id = $model->id;
         $model2->club_id = $club_model->id ;
         $model->apply_club_id  = $club_model->id;
         $model2->id_card_type = 843;
         put_msg('454');
         $model2->id_card_type_name = '身份证';
         $model2->real_sex = ($model->sex=='女')?207:205;
         $model2->id_card  = $model->id_card;
         $model2->club_status = 337;
         $model2->club_status_name = '已绑定';
         put_msg('461');
         $model2->apply_time = $model->apply_time;
         $model2->udate = $model->update;
         $model2->logon_way = $gfUser->logon_way;
         $model2->logon_way_name = $gfUser->logon_way_name;
         $model2->user_type = $model->type_name;
         $model2->zsxm=$model->zsxm;
         $model2->user_type = $model->type_name;
         // put_msg('成功到结尾结尾结尾');
         $sb = $model2->save();
         if($sa && $sb){
            $sc = 1;
            put_msg('473');
            return $sc;
         }
         else return 0;
         // show_status(1,'审核通过成功',Yii::app()->request->urlReferrer,'确认失败');
    }




    public function actionCreate_club() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update_club', $data);
        } else {

            $this->saveData($model,$_POST[$modelName]);
        }
    }
    
    public function actionUpdate_club($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update_club', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionUnuse($id,$new,$del) {
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'id in(' . $id . ')';
        $count = $model->updateAll(array($new => $del), $criteria);
        $al='申请退出成功';
        $bl='申请退出失败';
        if($del==1484){
            $al='解除成功';
            $bl='解除失败';
        }
        if ($count > 0) {
            if($del==1484){ //撤销
                $del_initiator=210;
                $relieve_time=null;
                if($del==1484){
                    $del_initiator=502;
                    $relieve_time=date('Y-m-d H:i:s', strtotime('7 days'));
                }
                $model->updateAll(array('apply_relieve_time' => date('Y-m-d H:i:s'),'relieve_time'=>$relieve_time,'del_initiator' => $del_initiator), $criteria);
                $model2=ClubMemberList::model()->find('gfpm_apply_id="'.trim($id).'"');
                put_msg($model2->id);
                $model2->club_status=338;
                $a2 = $model2->save();
            }
            else if($del==1485){
                 //退出
            }
            ajax_status(1, $al, returnList());
        } else {
            ajax_status(0, $bl);
        }
    }
    
    public function actionCancel($id,$new,$del) {
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'id in(' . $id . ')';
        $count = $model->updateAll(array($new => $del,'apply_relieve_time'=>null,'relieve_time'=>null), $criteria);
        if ($count > 0) {
            $model2=ClubMemberList::model()->find('gfpm_apply_id="'.trim($id).'"');
            put_msg($model2->id);
            $model2->club_status=337;
            $a2 = $model2->save();            
            ajax_status($a2, '撤销成功', returnList());
        } else {
            ajax_status(0, '撤销失败');
        }
    }
	
	function saveData($model,$post) {
        $modelName = $this->model;
        $model->attributes = $_POST[$modelName];
        $st=0;
        $count2=0;
        $count3=0;
        $al='保存失败';
        if($post['type']==403){
            $condition=' and gf_account='.$_POST['content']['2102']['677'];
        }elseif($post['type']==404){
            $condition=' and club_code='.$_POST['content']['2116']['677'];
        }
        if(!empty($model->id)){
            $condition.=' and id<>'.$model->id;
        }
        $count=GfPartnerMemberApply::model()->count('state=2 and auth_state in(931,1484,1485) and type='.$post['type'].' and partner_id='.$post['partner_id'].' and project_id='.$post['project_id'].$condition);
        if($_POST['submitType'] == 'shenhe'){
            $count2=GfPartnerMemberApply::model()->count('state=371 and auth_state=929 and type='.$post['type'].' and partner_id='.$post['partner_id'].' and project_id='.$post['project_id'].$condition);
        }
        if($_POST['submitType'] == 'yaoqing'){
            $count3=GfPartnerMemberApply::model()->count('state=371 and auth_state=1483 and type='.$post['type'].' and partner_id='.$post['partner_id'].' and project_id='.$post['project_id'].$condition);
        }
        if($count>0){
            $al='该单位已入会成功！';
        }
        if($count2>0){
            $al='请勿重复申请!';
        }
        if($count3>0){
            $al='请勿重复邀请!';
        }
        if($count<1&&$count2<1&&$count3<1){
            if ($_POST['submitType'] == 'shenhe') {
                $model->state = 371;
            } else if ($_POST['submitType'] == 'yaoqing') {
                $model->auth_state = 1483;
                $model->invite_initiator = 502;
            }  else if ($_POST['submitType'] == 'baocun') {
                $model->state = 721;
            } else if ($_POST['submitType'] == 'tongguo') {
                $model->state = 2;
                $model->entry_validity = date('Y-m-d H:i:s');
                $model->check_time = date('Y-m-d H:i:s');
            } else if ($_POST['submitType'] == 'butongguo') {
                $model->state = 373;
                $model->check_time = date('Y-m-d H:i:s');
            } else if ($_POST['submitType'] == 'jiechu') {
                $model->auth_state = 1473;
                $model->relieve_time = date('Y-m-d H:i:s');
            } else if ($_POST['submitType'] == 'bujiechu') {
                $model->auth_state = 931;
            } else {
                $model->state = 721;
            }
            $st=$model->save();
            if($st==1&&($model->state==2||$model->state==371||$model->auth_state==1483)){
                $this->save_content($model->id,$post['content'],$post['type']);
            }
        }
        show_status($st,'保存成功', returnList(),$al);
    }
    public function save_content($id,$setlist,$type){
        if(isset($_POST['content']))foreach($_POST['content'] as $s2 => $s3){
            $content = GfPartnerMemberContent::model()->find('apply_id='.$id.' and attr_id='.$s2);
            if(empty($content)){
                $content = new GfPartnerMemberContent();
                $content->isNewRecord = true;
                unset($content->id);
            }
            $content->apply_id = $id;
            $content->attr_id = $s2;
            $input=GfPartnerMemberInputset::model()->find('id='.$s2);
            $content->attr_name = $input->attr_name;
            $content->attr_unit = $input->attr_unit;
            foreach($s3 as $y => $y2){
                $content->attr_value_type = $y;
                if($y==677){
                    $content->attr_content = $y2;
                    $content->attr_value_id = '';
                    $content->attr_pic = '';
                }
                else if($y==678){
                    if(is_array($y2)){
                        foreach($y2 as $j => $j2){
                            $content->attr_value_id = $j;
                            $content->attr_content = $j2;
                            $content->attr_pic = '';
                        }
                    }
                }
                else if($y==681){
                    $content->attr_content = $y2;
                    $content->attr_value_id = '';
                    $content->attr_pic = '';
                }
                else if($y==683){
                    $content->attr_pic = $y2;
                    $content->attr_content = '';
                    $content->attr_value_id = '';
                }
                else if($y==720){
                    $content->attr_content = $y2;
                    $content->attr_pic = '';
                    $content->attr_value_id = '';
                }
            }
            $sc=$content->save();
        }
        // 个人信息
        if($type==403){
            $gf_account=GfPartnerMemberContent::model()->find("apply_id=".$id.' and apply_column="gf_account"'); //账号
            $gfid=userlist::model()->find('GF_ACCOUNT='.$gf_account->attr_content);//GF_ID
            $zsxm=GfPartnerMemberContent::model()->find("apply_id=".$id.' and apply_column="zsxm"'); //姓名
            $sex=GfPartnerMemberContent::model()->find("apply_id=".$id.' and apply_column="sex"'); //性别
            $nation=GfPartnerMemberContent::model()->find("apply_id=".$id.' and apply_column="nation"'); //民族
            $native=GfPartnerMemberContent::model()->find("apply_id=".$id.' and apply_column="native"'); //籍贯
            $birthdate=GfPartnerMemberContent::model()->find("apply_id=".$id.' and apply_column="birthdate"'); //出生年月
            $id_card=GfPartnerMemberContent::model()->find("apply_id=".$id.' and apply_column="id_card"'); //身份证号
            $duty=GfPartnerMemberContent::model()->find("apply_id=".$id.' and apply_column="duty"'); //工作单位
            $apply_address=GfPartnerMemberContent::model()->find("apply_id=".$id.' and apply_column="apply_address"'); //联系地址
            $apply_phone=GfPartnerMemberContent::model()->find("apply_id=".$id.' and apply_column="apply_phone"'); //联系电话
            $apply_email=GfPartnerMemberContent::model()->find("apply_id=".$id.' and apply_column="apply_email"'); //电子邮箱
            $head_pic=GfPartnerMemberContent::model()->find("apply_id=".$id.' and apply_column="head_pic"'); //免冠头像
            if($_POST['submitType'] == 'yaoqing'){
                GfPartnerMemberApply::model()->updateAll(['gf_account'=>$gf_account->attr_content,'gfid'=>$gfid->GF_ID],'id='.$id);
            }else{
                GfPartnerMemberApply::model()->updateAll(['gf_account'=>$gf_account->attr_content,'gfid'=>$gfid->GF_ID,'zsxm'=>$zsxm->attr_content,'sex'=>$sex->attr_content,'nation'=>$nation->attr_content,'native'=>$native->attr_content,'birthdate'=>$birthdate->attr_content,'id_card'=>$id_card->attr_content,'duty'=>$duty->attr_content,'apply_address'=>$apply_address->attr_content,'apply_phone'=>$apply_phone->attr_content,'apply_email'=>$apply_email->attr_content,'head_pic'=>$head_pic->attr_pic],'id='.$id);
            }
        }

        // 单位信息
        if($type==404){
            $club_code=GfPartnerMemberContent::model()->find("apply_id=".$id.' and apply_column="club_code"'); //单位账号
            $club_id=ClubList::model()->find('club_code="'.$club_code->attr_content.'"');//单位id
            $club_name=GfPartnerMemberContent::model()->find("apply_id=".$id.' and apply_column="club_name"'); //申请单位
            $company_type_id=GfPartnerMemberContent::model()->find("apply_id=".$id.' and apply_column="company_type_id"'); //单位性质
            $club_region=GfPartnerMemberContent::model()->find("apply_id=".$id.' and apply_column="club_region"'); //所在地区
            $club_address=GfPartnerMemberContent::model()->find("apply_id=".$id.' and apply_column="club_address"'); //单位地址
            $certificates_number=GfPartnerMemberContent::model()->find("apply_id=".$id.' and apply_column="certificates_number"'); //统一信用证号码
            $apply_club_gfnick=GfPartnerMemberContent::model()->find("apply_id=".$id.' and apply_column="apply_club_gfnick"'); //法定代表人
            $apply_club_phone=GfPartnerMemberContent::model()->find("apply_id=".$id.' and apply_column="apply_club_phone"'); //法定人联系电话
            $zsxm=GfPartnerMemberContent::model()->find("apply_id=".$id.' and apply_column="zsxm"'); //姓名
            $apply_phone=GfPartnerMemberContent::model()->find("apply_id=".$id.' and apply_column="apply_phone"'); //联系电话
            $apply_email=GfPartnerMemberContent::model()->find("apply_id=".$id.' and apply_column="apply_email"'); //电子邮箱
            $pcode=GfPartnerMemberContent::model()->find("apply_id=".$id.' and apply_column="pcode"'); //邮政编码
            if($_POST['submitType'] == 'yaoqing'){
                GfPartnerMemberApply::model()->updateAll(['club_code'=>$club_code->attr_content,'club_id'=>$club_id->id,'club_name'=>$club_name->attr_content],'id='.$id);
            }else{
                GfPartnerMemberApply::model()->updateAll(['club_code'=>$club_code->attr_content,'club_id'=>$club_id->id,'club_name'=>$club_name->attr_content,'company_type_id'=>$company_type_id->attr_value_id,'company_type'=>$company_type_id->attr_content,'club_region'=>$club_region->attr_content,'club_address'=>$club_address->attr_content,'certificates_number'=>$certificates_number->attr_content,'apply_club_gfnick'=>$apply_club_gfnick->attr_content,'apply_club_phone'=>$apply_club_phone->attr_content,'zsxm'=>$zsxm->attr_content,'apply_phone'=>$apply_phone->attr_content,'apply_email'=>$apply_email->attr_content,'pcode'=>$pcode->attr_content],'id='.$id);
            }
        }
    }
 
    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_clear($id);
    }

    public function actionGetMemberInputset($type,$club_id,$project_id) {
        $memberset = GfPartnerMemberSet::model()->find('club_id='. $club_id.' AND project_id ='.$project_id.' AND type='.$type);
        $data = GfPartnerMemberInputset::model()->findAll('set_id ='.$memberset->id);
        echo CJSON::encode($data);
    }

    public function actionDown($type,$club_id,$project_id,$set_input_id) {
        $memberset = GfPartnerMemberSet::model()->find('club_id='. $club_id.' AND project_id ='.$project_id.' AND type='.$type);
        $data = GfPartnerMemberValues::model()->findAll('set_id='.$memberset->id.' AND set_input_id='.$set_input_id);
        echo CJSON::encode($data);
    }

    public function actionPrompt($attr_values=0){
        $gf_values=GfPartnerMemberValues::model()->find();
        $show_val=$_POST['show_val'];
        if(!empty($gf_values)){
            ajax_status_attr(1,$gf_values->id,$gf_values->attr_values);
        }
    }

	 // gf帐号验证
     public function actionValidate($gf_account=0) {
        $user=userlist::model()->find('GF_ACCOUNT="'.$gf_account.'"');
        if(!empty($user)) {
            if($user->passed==2) {  
                $user_arr=['gfid'=>$user->GF_ID,'gf_account'=>$user->GF_ACCOUNT,'zsxm'=>$user->ZSXM,'sex'=>$user->real_sex,'native'=>$user->native,'birthdate'=>$user->real_birthday,'id_card'=>$user->id_card];
                ajax_status_attr(1,$user_arr);
            } else {
                ajax_status(0, '帐号未实名');
            }
         } else {
             ajax_status(0, '帐号不存在');
         }
  
     }
	 // 单位帐号验证
     public function actionvalidateCode($code=0,$project_id='') {
        $club=ClubList::model()->find('club_code='.$code);
        if(!empty($club)) {
            if($club->state==2&&$club->edit_state==2) {  
                $club_arr=['club_id'=>$club->id,'club_code'=>$club->club_code,'club_name'=>$club->club_name,'club_address'=>$club->club_address,'certificates_number'=>$club->certificates_number,'apply_name'=>$club->apply_name,'contact_phone'=>$club->contact_phone,'apply_club_gfnick'=>$club->apply_club_gfnick,'apply_club_phone'=>$club->apply_club_phone];
                $club_arr['pro_count']=ClubProject::model()->count('project_state=506 and auth_state=461 and p_code='.$code.' and project_id='.$project_id);
                ajax_status(1,'',$club_arr);
            }else{
                ajax_status(0, '该账号未完成注册');
            }
         } else {
             ajax_status(0, '帐号不存在');
         }
     }
     
	 // 获取单位模板
     public function actionMemberSet($type = 0, $partner_id = '', $project_id = '', $club_code='') {
        $set=GfPartnerMemberSet::model()->find('type='.$type.' and club_id='.$partner_id.' and project_id='.$project_id);

        $s_arr=[];
        $s_arr['pro_count']=ClubProject::model()->count('project_state=506 and auth_state=461 and p_code='.$club_code.' and project_id='.$project_id);
        if(isset($set))$inputset = GfPartnerMemberInputset::model()->findAll('set_id='.$set->id.' and type='.$type);
        $num=0;
        if(isset($inputset))foreach($inputset as $arr){
            if($arr->attr_input_type==678||$arr->attr_input_type==682){
                $s_arr['data'][$num]['datas']=[];
                $values = GfPartnerMemberValues::model()->findAll('set_id='.$set->id.' and set_input_id='.$arr->id);
                $index=0;
                foreach($values as $v){
                    $s_arr['data'][$num]['datas'][$index]['id']=$v->id;
                    $s_arr['data'][$num]['datas'][$index]['attr_values']=$v->attr_values;
                    $index++;
                }
            }
            $s_arr['data'][$num]['id']=$arr->id;
            $s_arr['data'][$num]['set_id']=$arr->set_id;
            $s_arr['data'][$num]['attr_name']=$arr->attr_name;
            $s_arr['data'][$num]['attr_unit']=$arr->attr_unit;
            $s_arr['data'][$num]['attr_input_type']=$arr->attr_input_type;
            $s_arr['data'][$num]['sort_order']=$arr->sort_order;
            $s_arr['data'][$num]['is_required']=$arr->is_required;
            $num++;
        }
        ajax_exit($s_arr);
     }
     public function actionapplyjoin1($gf_account="",$club_id="",$zsxm="",$sex="",$phone="",$id_card="",$type_name="",$address="",$id_card_face,$id_card_back=""){
        $res = '申请入驻成功，请耐心等待审核！';
        $code=200;
        JsonSuccess($res,$code);    
     }

    // 微信表单入驻申请-----zx测试
     public function actionapplyjoin($gf_account="",$club_id="",$zsxm="",$sex="",$phone="",$id_card="",$type_name="",$address="",$id_card_face,$id_card_back=""){
        put_msg('进来');
        $modelName = $this->model;
        put_msg($gf_account);
        // $user = GfUser1::model()->find('gf_account='.$gf_account);
        $modelapply = $modelName::model()->find('gf_account='.$gf_account);
        $modelclub = ClubListSqdw::model()->find('id="'.trim($club_id).'"');
        if(empty($modelclub)){
            $res = '单位异常！';
            $code=201;
            JsonSuccess($res,$code);   
            return;
        }
        if(!empty($modelapply)){
            put_msg('856');
            // 考虑可先写一个判断函数function,判断是否申请状态或者什么什么，这里先写在这个函数里面
            if($modelapply->auth_state==929) {
                $res = '您已申请，请耐心等待审核！';
                $code=202;
                JsonSuccess($res,$code);
                return;
            } 
            else if($modelapply->auth_state==931 && $modelapply->apply_club_code!='2018000094'){
                put_msg('863');
                $res = '您已绑定厨房，不可重复加入！';
                $code=203;
                JsonSuccess($res,$code);
                return;
            }else{
                put_msg('newapplypast');
                $modelapply = new $modelName();
                $modelapply->gf_account=$gf_account;
            }
        }
        if(empty($modelapply)){
            put_msg('nonapplypast');
            $modelapply = new $modelName();
            $modelapply->gf_account=$gf_account;            
        }
        //如果能够申请，且存在记录，则在原记录更改
            put_msg('849');
            // 考虑这些操作放在model写
            $modelapply->zsxm=$zsxm;
            $modelapply->sex=$sex;
            put_msg('853');
            $modelapply->apply_phone=$phone;
            put_msg('854');
            $modelapply->id_card=$id_card;
            // if($type_index==0){
            //     $modelapply->type=1720;
            //     $modelapply->type_name="厨师";
            // }else{
            //     $modelapply->type=1721;
            //     $modelapply->type_name="普通用户";
            // }
            $modelapply->type_name=$type_name;
            $modelapply->auth_state=929;
            $modelapply->state=371;
            $modelapply->state_name='待审核';
            $modelapply->auth_state_name='待审核';
            put_msg('865');
            // $modelapply->apply_club_id = $modelclub->id;
            $modelapply->apply_club_id=$club_id;
            $modelapply->apply_club_code=$modelclub->club_code;
            $modelapply->apply_club_name=$modelclub->club_name;
            $modelapply->update=null;
        // }
        $sa = $modelapply->save();
        // $sa=1;
        if($sa){
            $res = '申请入驻成功，请耐心等待审核！';
            $code=200;
            JsonSuccess($res,$code);            
        }else{
            $res = '申请失败，请联系管理员！';
            $code=204;
            JsonSuccess($res,$code);    
        }

        // if(!empty($user)){
        //     if($user->GF_PASS==md5($pass)) {  //验证密码，正确
        //         $sa=1;
        //         $res=$user->getzxwxInfo();        
        //     }
        //     if(empty($res)) $res=array();
        //     $code = (!empty($res['id']) && $sa)?200:201;  //200代表成功
        //     JsonSuccess($res,$code);
        // }else{
        //     $code=201;
        //     $res=array();
        //     JsonSuccess($res,$code);
        // }

     }
 //申请记录
    public function actionapplyrecord($user_account=""){
        $criteria = new CDbCriteria;
        $criteria->order = "id DESC";
        $criteria->addCondition("gf_account =".$user_account); //通过
        $res = GfPartnerMemberApply::model()->findAll($criteria);
        JsonSuccess($res);    
     }
}
