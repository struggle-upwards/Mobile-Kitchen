
<div class="box">
    <a class="btn" href="javascript:;" onclick="we.reload();" style="vertical-align: middle;float: right; margin-right: 10px;"><i class="fa fa-refresh"></i>刷新</a>
    <div class="box-title c">当前界面 》 会员 》 单位成员管理 》 入会审核管理</h1></div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="state" value="<?php echo Yii::app()->request->getParam('state');?>">
                <!-- <input type="hidden" name="type" value="<?php echo Yii::app()->request->getParam('type');?>"> -->
                <!-- <label style="margin-right:20px;">
                    <span>会员类型：</span>
                    <?php //echo downList($type,'f_id','F_NAME','type'); ?>
                </label> -->
                <label style="margin-right:10px;">
                    <span>申请时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo Yii::app()->request->getParam('start_date');?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo Yii::app()->request->getParam('end_date');?>">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入姓名/账号/项目">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>

                            <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                            <th>序号</th>
                            <th>会员账号</th>
                            <th>姓名</th>
                            <th>性别</th>
                            <th><?php echo $model->getAttributeLabel('apply_club_code');?></th>
                            <th>申请加入单位名称</th>
                            <th>联系电话</th>
                            <th>身份证号</th>
                            <!-- <th><?php echo $model->getAttributeLabel('company_type_id');?></th> -->
                            <!-- <th><?php echo $model->getAttributeLabel('club_region');?></th>  -->
                            <!-- <th><?php echo $model->getAttributeLabel('apply_phone');?></th> -->
                            <th><?php echo $model->getAttributeLabel('state');?></th>
                            <th><?php echo $model->getAttributeLabel('apply_time');?></th>
                            <th>操作</th>
                    </tr>
                </thead>
                <tbody>
<?php 
    $index = 1;
    foreach($arclist as $v){ 
?>
                    <tr>
          
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->gf_account; ?></td>
                            <td><?php echo $v->zsxm; ?></td>
                            <td><?php echo $v->sex; ?></td>
                            <td><?php echo $v->apply_club_code; ?></td>
                            <td><?php echo $v->apply_club_name; ?></td>
                            <td><?php echo $v->apply_phone; ?></td>
                            <td><?php echo $v->id_card; ?></td>
                            <td><?php echo $v->state_name; ?></td>
                            <td><?php echo $v->apply_time; ?></td>
                            <td>
                                <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除">删除</a>
                            </td>
                    </tr>
<?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages);?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
    var cancelUrl = '<?php echo $this->createUrl('cancel', array('id'=>'ID','new'=>'state','del'=>374));?>';
    $(function(){
        var $start_date=$('#start_date');
        var $end_date=$('#end_date');
        $start_date.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
        });
        $end_date.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
        });
    });
</script>