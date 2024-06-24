<div class="box">
    <div class="box-title c">
        <h1>当前界面：培训/活动 》活动发布 》发布活动</h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <?php echo show_command('添加',$this->createUrl('CreateHzj'),'添加'); ?>
            <?php echo show_command('批删除','','删除'); ?>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="index" value="<?php echo Yii::app()->request->getParam('index');?>">
<!-- 				<label style="margin-right:20px;">
                    <span>项目：</span>
                    <?php //echo downList($project_list,'project_id','project_name','project_id'); ?>
                </label> -->
                <label>
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" id="keywords" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="活动编号/活动标题">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
                <input id="is_excel" type="hidden" name="is_excel" value="0">
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th>活动编号</th>
                        <th>活动标题</th>
                        <th>活动地点</th>
                        <th>联系人</th>
                        <th>联系电话</th>
                        <th>活动费用（元）</th>
                        <th>可报名人数</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $index = 1; 
                    foreach($arclist as $v){ 
                    ?>
                        <tr id="hidden_<?php echo $v->id?>">
                <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                <td><?php echo $v->activity_code; ?></td>
                <td><?php echo $v->activity_title; ?></td>
                <td><?php echo $v->activity_address; ?></td>
                <td><?php echo $v->local_men; ?></td>
                <td><?php echo $v->local_and_phone; ?></td>
                <td><?php echo $v->activity_cost; ?></td>
                <td><?php echo $v->enrole_num; ?></td>
                <td><?php echo $v->state_name; ?></td>
                <td>
                <a class="btn" onclick="tijiao('<?php echo $v->id?>')" title="提交">提交</a>
                <a class="btn" href="<?php echo $this->createUrl('UpdateHzj', array('id'=>$v->id));?>" title="编辑">编辑</a>
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
    var deleteUrl = '<?php echo $this->createUrl('ActivityList/DeleteHzj', array('id'=>'ID'));?>';
</script>
<script>
    function tijiao(modelid) {
        $.ajax({
            type: 'get',
            url: "<?php echo $this->createUrl('ActivityList/Tijiao');?>",
            data: {
                modelid:modelid
            },
            dataType: 'json',
            success: function(data){
                var s1 = document.getElementById("hidden_"+data.modelid);
                s1.style.display = 'none';
            }
        });
    }
</script>