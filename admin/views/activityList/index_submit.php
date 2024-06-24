<div class="box">
    <div class="box-title c">
        <h1>当前界面：培训/活动 》活动发布 》待审核列表</h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>&nbsp;&nbsp;
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
				<label style="margin-right:20px;">
                    <span>项目：</span>
                    <?php echo downList($project_list,'project_id','project_name','project_id'); ?>
                </label>
                <label>
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" id="keywords" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入编号或标题">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
                <input id="is_excel" type="hidden" name="is_excel" value="0">
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('activity_code');?></th>
                        <th><?php echo $model->getAttributeLabel('activity_title');?></th>
                        <!-- <th>活动内容</th> -->
                        <th>费用（元）</th>
                        <th>报名时间</th>
                        <th>活动时间</th>
                        <th><?php echo $model->getAttributeLabel('local_and_phone');?></th>
                        <?php if(empty($_REQUEST['state'])){?>
                            <th>审核状态</th>
                            <th><?php echo $model->getAttributeLabel('audit_time');?></th>
                            <th><?php echo $model->getAttributeLabel('adminid');?></th>
                        <?php }else{ ?>
                            <th>申请日期</th>
                        <?php } ?>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $index = 1; foreach($arclist as $v){ 
                            $pName = ActivityListData::model()->findAll('activity_id='.$v->id);
                            $tx='';
                            $nr='';
                            $min=0.00;
                            $max=0.00;
                            if(!empty($pName)){
                                $min=$pName[0]->activity_money;
                                $max=$pName[0]->activity_money;
                            }
                            foreach($pName as $i=>$h){
                                $tx.=$h->project_name.',';
                                $nr.=$h->activity_content.',';
                                if($min>$pName[$i]->activity_money){
                                    $min = $pName[$i]->activity_money;
                                }
                                if($max<$pName[$i]->activity_money){
                                    $max = $pName[$i]->activity_money;
                                }
                            }
                            $tx=rtrim($tx, ',');
                            $nr=rtrim($nr, ',');
                    ?>
                        <tr>
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->activity_code; ?></td>
                            <td title="<?= $v->activity_title;?>"><span style="display:inline-block;max-width: 150px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;"><?php echo $v->activity_title; ?></span></td>
                            
                            <!-- <td><?php echo $v->brief; ?></td> -->
                            <td><?php echo $v->price; ?></td>
                            <td><?php echo $v->sign_up_date.'<br>'.$v->sign_up_date_end; ?></td>
                            <td><?php echo $v->activity_time.'<br>'.$v->activity_time_end; ?></td>
                            <td><?php echo $v->local_and_phone; ?></td>
                            <?php if(empty($_REQUEST['state'])){?>
                                <td><?php echo $v->state_name; ?></td>
                                <td><?php echo date('Y-m-d',strtotime($v->audit_time)); ?></td>
                                <td><?php echo $v->adminname; ?></td>
                            <?php }else{ ?>
                                <td><?php echo $v->uDate; ?></td>
                            <?php } ?>
                            <td>
                                <?php echo show_command(empty($_REQUEST['state'])?'详情':'审核',$this->createUrl('update', array('id'=>$v->id,'disabled'=>'disabled'))); ?>
                                <?php echo $v->state==373?show_command('删除','\''.$v->id.'\''):''; ?>
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
    var cancelUrl = '<?php echo $this->createUrl('cancel', array('id'=>'ID','new'=>'state','del'=>721,'yes'=>'撤销成功','no'=>'撤销失败'));?>';
</script>