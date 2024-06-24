<?php  
  $title='系统>权限管理>小程序账号授权';
 ?>
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i><?php echo $title;?></h1></div><!--box-title end-->
    <div class="box-content">
    <div class="box-header">
    <!-- <a class="btn" href="<?php echo $this->createUrl('gfuser1/indexAdd',array());?>"><i class="fa fa-plus"></i>添加</a> -->
    <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
    <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="gfuser1/indexAdd">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->

<div class="box-table">
    <table class="list">
    <thead>
        <tr>
                        <th width="8.8%"><?php echo $model->getAttributeLabel('security_phone');?></th>
                        <th width="8.8%"><?php echo $model->getAttributeLabel('GF_NAME');?></th>
                        <th width="8.8%"><?php echo $model->getAttributeLabel('roleName');?></th>
                        <th width="8.8%"><?php echo $model->getAttributeLabel('user_state');?></th>
                        <th width="8.8%"><?php echo $model->getAttributeLabel('passed');?></th>
                        <!-- <th ><?php //echo $model->getAttributeLabel('ZSXM');?></th> -->
                        <th width="8.8%"><?php echo $model->getAttributeLabel('REGTIME');?></th>
                        <th width="8.8%">有效期限</th>
                        <th width="8.8%"><?php echo $model->getAttributeLabel('logon_way');?></th>
                        <th width="8.8%"><?php echo $model->getAttributeLabel('gf_reg_address');?></th>
                        <th width="8.8%"><?php echo $model->getAttributeLabel('gf_reg_client');?></th>
                        <th width="8.8%">操作</th>
        </tr>
    </thead>
    <tbody>
<?php  foreach($arclist as $v){ ?>
<tr>
                        <td ><?php echo CHtml::link($v->security_phone, array('id'=>$v->GF_ID)); ?></td>
                        <td ><?php echo CHtml::link($v->GF_NAME, array('id'=>$v->GF_ID)); ?></td>
                        <td ><?php echo CHtml::link($v->roleName, array('id'=>$v->GF_ID)); ?></td>
                        <td ><?php echo $v->user_state_name; ?></td>
                        <td ><?php echo $v->passed_name; ?></td>
                        <!-- <td ><?php // echo $v->ZSXM; ?></td> -->
                        <td ><?php echo substr($v->REGTIME,0,10); ?></td>
                        <td>
                            <?php
                                $left = substr($v->valid_date,0,10);
                                $right = substr($v->valid_date,11);
                                echo $left.' '.$right.'<br>'.$v->end_valid_date;
                            ?>
                        </td>
                        <td ><?php echo $v->logon_way_name; ?></td>
                        <td ><?php echo $v->gf_reg_address; ?></td>
                        <td >
                            <?php
                                if($v->gf_reg_client==1){
                                    echo 'PC';
                                }elseif($v->gf_reg_client==2){
                                    echo 'MAC';
                                }elseif($v->gf_reg_client==3){
                                    echo '苹果';
                                }elseif($v->gf_reg_client==4){
                                    echo 'IPAD';
                                }elseif($v->gf_reg_client==5){
                                    echo '安卓';
                                }elseif($v->gf_reg_client==6){
                                    echo 'APAD';
                                }elseif($v->gf_reg_client==7){
                                    echo '网页';
                                }elseif($v->gf_reg_client==8){
                                    echo '其他';
                                }
                            ?>
                        </td>
                        <td >
                            <?php echo show_command('详情',$this->createUrl('updateAdd', array('id'=>$v->GF_ID))); ?>
                            <!-- <?php //echo show_command('删除','\''.$v->GF_ID.'\''); ?> -->
                        </td>
</tr>
<?php } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->

<script>

var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
var resetUrl = '<?php echo $this->createUrl('resetPassword', array('id'=>'ID'));?>';

// 发送邀请
var resetPass=function(pid){
    we.loading('show');
    $.ajax({
        type: 'get',      
        url: '<?php echo $this->createUrl('resetPassword');?>',
        dataType: 'json',
        success: function(data) {
        
            if(data.status==1){
                we.loading('hide');
                $.dialog.list['addlianmeng'].close();
                we.success(data.msg, data.redirect);
            }else{
                we.loading('hide');
                we.msg('minus', data.msg);
            }
        }
    });
    return false;
};
</script>
