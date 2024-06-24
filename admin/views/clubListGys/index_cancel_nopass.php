<div class="box">
    <div class="box-title c">
        <h1> <span>当前界面：供应商》意向入驻管理》审核未通过列表</span> </h1>
        <span style="float:right;padding-right:15px;"> <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a> </span>
    </div>
    <!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url; ?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r'); ?>">
                <label style="margin-right:10px;">
                    <span>审核时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo $start_date;?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo $end_date;?>">
                </label>
                <label style="margin-right:10px;">
                    <span>所在地：</span>
                    <input style="width:200px;" class="input-text" type="text" name="location" value="<?php echo Yii::app()->request->getParam('location'); ?>" placeholder="请输入所在地">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords'); ?>" placeholder="请输入账号/名称">
                </label>
                <button id="click_submit" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div>

        <div class="box-table">
            <table class="list" style="text-align:left;">
                <thead>
                    <tr>
                        <th width="20" class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th width="49">序号</th>
                        <th><?php echo $model->getAttributeLabel('club_code'); ?></th>
                        <th><?php echo $model->getAttributeLabel('company'); ?></th>
                        <th><?php echo $model->getAttributeLabel('company_type_id'); ?></th>
                        <th><?php echo $model->getAttributeLabel('club_address'); ?></th>
                        <th><?php echo $model->getAttributeLabel('apply_name'); ?></th>
                        <th><?php echo $model->getAttributeLabel('contact_phone'); ?></th>
                        <th><?php echo $model->getAttributeLabel('state'); ?></th>
                        <th><?php echo $model->getAttributeLabel('pass_time'); ?></th>
                        <th>审核员</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $index = 1;
                    foreach ($arclist as $v) {
                        if (!empty(explode(",", $v->club_area_code)[0])) $tRegion = TRegion::model()->find('id=' . explode(",", $v->club_area_code)[0]);
                        if (!empty(explode(",", $v->club_area_code)[1])) $tRegion2 = TRegion::model()->find('id=' . explode(",", $v->club_area_code)[1]);
                        $region = "";
                        if (!empty($tRegion)) $region .= $tRegion->region_name_c;
                        if (!empty($tRegion2)) $region .= $tRegion2->region_name_c;
                        ?>
                        <tr>
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->club_code; ?></td>
                            <td><?php echo $v->company; ?></td>
                            <td><?php echo $v->company_type;  ?></td>
                            <td><?php echo $v->club_area_code != "" ? $region : ''; ?></td>
                            <td><?php echo $v->apply_name; ?></td>
                            <td><?php echo $v->contact_phone; ?></td>
                            <td><?php echo $v->state_name; ?></td>
                            <td><?php echo $v->pass_time; ?></td>
                            <td><?php echo (!is_null($v->reasonsAdmin)?$v->reasonsAdmin->admin_gfaccount:'').'/'.$v->reasons_adminname; ?></td>
                            <td>
                                <?php echo show_command('详情',$this->createUrl('update', array('id'=>$v->id, 'action' => 'index_cancel_nopass'))); ?>
                                <a class="btn" onclick="logout(<?=$v->id?>)">注销</a>
                            </td>
                        </tr>
                    <?php $index++;
                    } ?>
                </tbody>
            </table>
        </div>
        <!--box-table end-->

        <div class="box-page c">
            <?php $this->page($pages); ?>
        </div>
    </div>
    <!--box-content end-->
</div>
<!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id' => 'ID')); ?>';

    var $start_time=$('#start_date');
    var $end_time=$('#end_date');
    $start_time.on('click', function(){
        var end_input=$dp.$('end_date')
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false,onpicked:function(){end_input.click();},maxDate:'#F{$dp.$D(\'end_date\')}'});
    });
    $end_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false,minDate:'#F{$dp.$D(\'start_date\')}'});
    });

    function logout(id){
        we.loading('show');
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('clubList/updata_club');?>',
            data: {deal_id: id,user_state: 649,lock_reason: "系统注销"},
            dataType: 'json',
            success: function(data) {
                console.log(data)
                if(data.status==1){
                    we.loading('hide');
                    we.success(data.msg, data.redirect);
                }else{
                    we.loading('hide');
                    we.msg('minus', data.msg);
                }
            }
        });
        return false;
    }
</script>