<?php  $form = $this->beginWidget('CActiveForm', get_form_list()); 
  $new=1;
  if (!isset($_REQUEST['p_id'])) {$_REQUEST['p_id']=0;}
  if (isset( $_REQUEST['f_type'] ) ) {
       $new=0;
   }
   $model->p_id=$_REQUEST['p_id'];
   $tc=$model->p_id;
   if ($_REQUEST['club_type']==-1) {
    $_REQUEST['club_id']=get_session('club_id');
    $club_name='系统>权限管理>'.get_session('club_name').'角色权限设置';

  } else
  {
    $_REQUEST['club_id']=0;
    $club_name="系统>权限管理>平台角色权限设置";
  }
   if (get_SESSION('use_club_id')=='0'){
    } else {
      $mod1=Role::model()->find('club_id='.$model->club_id.' and f_type=1');
      if(!empty($mod1)){
          $model->f_club_item_type=$mod1->f_club_item_type; 
          $model->f_club_item_type_name=$mod1->f_club_item_type_name;
          $model->f_club_type=$mod1->f_club_type;
          $model->f_club_type_name=$mod1->f_club_type_name;
         }
      $model->club_id=get_session('club_id');
   
    }
    $model->f_tcode=$_REQUEST['f_tcode'];
    
 ?>
 <div class="box">
    <div class="box-title c">
    <h1><i class="fa fa-table"></i>【当前界面：<?php echo $club_name;?>>详情】</h1><span class="back">
    <a class="btn" href="javascript:;" onclick="we.back();">
    <i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
  <hr style="height:1px;border:none;border-top:1px solid #666;" />
    <div class="box-detail">
 <div class="box">
    <div class="box-title c"><h1>【角色设置】</h1>
  </div><!--box- >end-->
  <div class="box-detail-bd">
      <div style="display:block;" class="box-detail-tab-item">
          <table class="mt15"  >
        <tr>
            <td width="15%"><?php echo $form->labelEx($model, 'f_rcode').'前部分编码('.$_REQUEST['f_tcode']; ?>)</td>
            <td width="35%"><?php echo $form->textField($model, 'f_rcode', array('class' => 'input-text','onchange'=>'check_code(this,'."'".$_REQUEST['f_tcode']."');")); ?>
                <?php echo $form->error($model, 'f_rcode', $htmlOptions = array()); ?></td>
            <td width="15%"><?php echo $form->labelEx($model, 'f_rname'); ?></td>
            <td width="35%">
                <?php echo $form->textField($model, 'f_rname', array('class' => 'input-text')); ?>
                <?php echo $form->error($model, 'f_rname', $htmlOptions = array()); ?>
            </td>
       </tr>

           <?php if(empty($model->f_tcode)) { ?>
         <tr>
            <td><?php echo $form->labelEx($model, 'f_temporary'); ?></td>
            <td colspan="3">
            <?php echo $form->radioButtonList($model, 'f_temporary', Chtml::listData(BaseCode::model()->temporary(), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
            </td>
      
        </tr>
           <?php  } ?>
    </table>
      <?php echo $form->hiddenField($model, 'f_tcode', array('class' => 'input-text')); ?>        
      <?php echo $form->hiddenField($model, 'f_type', array('class' => 'input-text')); ?>
      <?php echo $form->hiddenField($model, 'p_id', array('class' => 'input-text')); ?>
      <?php echo $form->hiddenField($model, 'if_delete', array('class' => 'input-text')); ?>
  
       <input type="hidden" name="Role[club_id]" id="Role_club_id" value="<?php echo get_session('club_id');?>">
      
   <table class="mt15">
    <tr>
        <td width="10%">主菜单</td>
        <td width="10%">二级菜单</td>
        <td width="80%">功能授权</td>
        </tr>
  <?php 
    $m1=new Menu();
    $m2=' order by f_code';
    $r=0;$opds=$model->f_opter;
    if(is_string($opds))
       $opds=explode(',',$opds);
    foreach($mainmenu as  $v) {
      $w1='f_mtype=1 and f_code like "'.trim($v->f_code).'%"';
  
      $tmp1=$m1->findAll($w1.$m2);
      foreach($tmp1 as  $v1) {
         $s2=substr($v1->f_code, 0,3);
         $w1='f_mid=0 and f_mtype=2 and f_code like "'.$s2.'%"';
         $tmp2=$m1->findAll($w1.$m2);
         if($tmp2){
            ?> 
            <tr><td><?php echo $v->f_name;?></td>
           <td><?php echo $v1->f_name;?></td>
           <?php 
            $sn0='opt'.$r;    $r++;
            $model[$sn0]=$opds;
            $s0=$sn0.':check(Menu/mlist/'.$s2.'):0:1';
            echo readData($form,$model,$s0);?>
           </tr>
         <?php } //if
           }  //for v1
          }  //for v
          ?> 
        </table>
        </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
     
        <div class="box-detail-submit">
          <?php echo show_shenhe_box(array('baocun'=>'保存'));?>
          <button class="btn" type="button" onclick="we.back();">取消</button>
         </div>
<?php $this->endWidget();?>
</div><!--box-detail end-->
</div><!--box end-->

