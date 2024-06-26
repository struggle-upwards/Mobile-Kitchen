<div class="box">
    <div class="box-title c">
        <h1> <span>当前界面：供应商》意向入驻管理》意向入驻审核》待审核</span> </h1>
        <span style="float:right;padding-right:15px;"> <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a> </span>
    </div>
    <!--box-title end-->
    <div class="box-content">

        <!--        <div class="box-detail-tab" style="margin-top:10px;">
                    <ul class="c">
                        <li class="current">冻结操作</li>
                        <li onclick="click_li();">解冻操作</li>
                    </ul>
                </div>-->

        <!--<div class="box-header" >
    <a class="btn" href="<?php //echo $this->createUrl('create');
                            ?>"><i class="fa fa-plus"></i>添加</a>
    <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>

    </div>-->

        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url; ?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r'); ?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords'); ?>" placeholder="请输入单位账号/名称">
                </label>
                <button id="click_submit" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div>

        <div class="box-table">
            <table class="list" style="text-align:left;">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('club_code'); ?></th>
                        <th><?php echo $model->getAttributeLabel('company'); ?></th>
                        <th><?php echo $model->getAttributeLabel('company_type_id'); ?></th>
                        <th><?php echo $model->getAttributeLabel('club_address'); ?></th>
                        <th><?php echo $model->getAttributeLabel('apply_name');?></th>
                        <th><?php echo $model->getAttributeLabel('contact_phone');?></th>
                        <th>状态</th>
                        <th><?php echo $model->getAttributeLabel('apply_time');?></th>
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
                            <td><?php echo $v->apply_name;  ?></td>
                            <td><?php echo $v->contact_phone;  ?></td>
                            <td><?php echo $v->state_name;?></td>
                            <td><?php echo substr($v->apply_time,0,10);?></td>
                            <td>
                                <?php echo show_command('审核',$this->createUrl('update', array('id'=>$v->id,'action' => 'index_no_exam'))); ?>
                            </td>
                        </tr>
                    <?php $index++;} ?>
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
</script>