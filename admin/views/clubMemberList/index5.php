<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>单位会员管理列表</h1></div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('create');?>"><i class="fa fa-plus"></i>添加</a>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>注册时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="regtime" name="regtime" value="<?php echo $regtime;?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="endregtime" name="endregtime" value="<?php echo $endregtime;?>">
                </label>
                <label style="margin-right:10px;">
                    <span>归属单位：</span>
                    <input style="width:200px;" class="input-text" type="text" name="key_club" value="<?php echo Yii::app()->request->getParam('key_club');?>" >
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" placeholder="请输入账号/姓名/用户类型" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('gf_account'); ?></th>
                        <th><?php echo $model->getAttributeLabel('zsxm'); ?></th>
                        <th><?php echo $model->getAttributeLabel('real_sex'); ?></th>
                        <th><?php echo $model->getAttributeLabel('user_type'); ?></th>
                        <th><?php echo $model->getAttributeLabel('club_name'); ?></th>
                        <th><?php echo $model->getAttributeLabel('club_status_name'); ?></th>
                         <th>注册时间</th>
                         <th>操作</th>
                    </tr>
                </thead>
                <tbody>
<?php
$index = 1;
 foreach($arclist as $v){ ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td> 
                        <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->gf_account; ?></td>
                            <td><?php echo $v->zsxm; ?></td>
                            <td><?php if($v->base_code_sex != null)echo $v->base_code_sex->F_NAME;?></td>
                            <td><?php echo $v->user_type; ?></td>
                            <td><?php echo $v->club_name; ?></td>
                            <td><?php if(!is_null($v->base_code_status))echo $v->base_code_status->F_NAME;?></td>
                            <td><?php if(!is_null($v->gf_user_1)) echo $v->gf_user_1->REGTIME; else put_msg('nogfuser1');?></td>
                            <td>
                                    <?php echo show_command('修改',$this->createUrl('update', array('id' => $v->id, 'member_gfid' => $v->member_gfid,'index'=>5))); ?>
                                    <?php if ($v->club_status == 337){ ?>
                                        <a class="btn" href="javascript:;" onclick="unuse('<?php echo $v->id;?>', unuseUrl);" title="解除">解除</a>
                                    <?php }elseif ($v->club_status == 497) { ?>
                                        <a href="javascript:;" onclick="to_revoke_relieve(<?php echo $v->id; ?>)" class="btn">撤销</a>
                                    <?php } ?>
                            </td>
                        
                    </tr>
<?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
</script>
<script>
// $(function(){
//     var $start_time=$('#start_date');
//     var $end_time=$('#end_date');
//     $start_time.on('click', function(){
//         var end_input=$dp.$('end_date')
//         WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:false,onpicked:function(){end_input.click();},maxDate:'#F{$dp.$D(\'end_date\')}'});
//     });
//     $end_time.on('click', function(){
//         WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:false,minDate:'#F{$dp.$D(\'start_date\')}'});
//     });
// });

$(function(){
        var $regtime=$('#regtime');
        var $endregtime=$('#endregtime');
        $regtime.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
        });
        $endregtime.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
        });
    });

    var unuseUrl = '<?php echo $this->createUrl('unuse', array('id'=>'ID','new'=>'club_status','del'=>497));?>';  //如果要退出 del改为338

        var unuse = function(id, url) {
        we.overlay('show');
        if (id == '' || id == undefined) {
            we.msg('error', '请选择要解除的单位', function() {
                we.loading('hide');
            });
            return false;
        }
        var fnUnuse = function() {
            url = url.replace(/ID/, id);
            console.log(url)
            $.ajax({
                type: 'get',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.status == 1) {
                        we.msg('check', data.msg, function() {
                            we.loading('hide');
                            we.reload();
                        });
                    } else {
                        we.msg('error', data.msg, function() {
                            we.loading('hide');
                        });
                    }
                }
            });
        };
        $.fallr('show', {
            buttons: {
                button1: {text: '解除', danger: true, onclick: fnUnuse},
                button2: {text: '取消'}
            },
            content: '确定解除？',
            icon: 'trash',
            afterHide: function() {
                we.loading('hide');
            }
        });
    };

    $("#batch_revoke").on("click", function() {
        var str = "";

        $(".check-item .input-check:checked").each(function() {
            str += $(this).attr('value') + ',';
        })
        if (str.length > 0) {
            str = str.substring(0, str.length - 1);
        } else {
            we.msg('minus', '你未选中记录');
            return false;
        }
        to_relieve_apply(str);
        //console.log(str);
    })
</script>