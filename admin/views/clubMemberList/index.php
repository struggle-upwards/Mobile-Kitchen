<?php

if ($_REQUEST['index'] == 1) {
    $txt = '邀请学员';
} elseif ($_REQUEST['index'] == 2) {
    $txt = '邀请学员》今日邀请';
} elseif ($_REQUEST['index'] == 3) {
    $txt = '学员审核';
} elseif ($_REQUEST['index'] == 4) {
    $txt = '学员审核》待审核';
} elseif ($_REQUEST['index'] == 5) {
    $txt = '学员列表';
} elseif ($_REQUEST['index'] == 6) {
    $txt = '学员解除';
} elseif ($_REQUEST['index'] == 7) {
    $txt = '审核未通过';
} elseif ($_REQUEST['index'] == 8) {
    $txt = '各单位学员查询';
}


if ($_REQUEST['index'] == 3) {
    $date_str = '审核时间';
} elseif ($_REQUEST['index'] == 1) {
    $date_str = '邀请时间';
} elseif ($_REQUEST['index'] == 4) {
    $date_str = '申请时间';
} elseif ($_REQUEST['index'] == 7) {
    $date_str = '操作时间';
} else {
    $date_str = '注册时间';
}
?>
<div id="mask" style="display:none;width: 100%; height: 100%; position: fixed; z-index: 2000; top: 0px; left: 0px; overflow: hidden;">
    <div class="" style="line-height: 30px;position: absolute;top: calc(50% - 15px);left: calc(50% - 115px);"><span>导入中...</span></div>
</div>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：会员》学员管理》<?php echo $txt; ?></h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div>
    <div class="box-content">
        <div class="box-header" <?php if ($_REQUEST['index'] == 4 || $_REQUEST['index'] == 5 || $_REQUEST['index'] == 6 || $_REQUEST['index'] == 7 || $_REQUEST['index'] == 8) {
                                    echo 'style="display:none;"';
                                } ?>>
            <?php if ($_REQUEST['index'] == 3) { ?>
            <?php } elseif (get_session('club_id') <> 1 && get_session('club_id') <> NULL && $_REQUEST['index'] != 5) { ?>
                <a class="btn" href="javascript:;" onclick="fnAddClub();"><i class="fa fa-plus"></i>邀请</a>
            <?php } ?>

            <?php if ($_REQUEST['index'] == 1) { ?>
                <span class="exam"> <!-- onclick="on_exam();" -->
                    <p>今日邀请：<span style="color:red;font-weight: bold;"><?php echo $count1; ?></span></p>
                </span>
            <?php } elseif ($_REQUEST['index'] == 3) { ?>
                <span class="exam" onclick="on_exam2()">
                    <p>待审核：<span style="color:red;font-weight: bold;"><?php echo $count2; ?></span></p>
                </span>

            <?php } ?>

            <!-- <?php //if ($_REQUEST['index'] == 5) { ?>
                <button class="btn btn-blue" type="button" onclick="javascript:importfile()">导入</button>
                <a class="btn" href="javascript:;" type="button" onclick="javascript:excel();"><i class="fa fa-file-excel-o"></i>导出</a>
            <?php //} ?> -->
        </div>
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url; ?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r'); ?>">
                <input type="hidden" name="news_type" value="<?php echo Yii::app()->request->getParam('news_type'); ?>">
                <input type="hidden" name="index" id="index" value="<?php echo Yii::app()->request->getParam('index'); ?>">



                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" placeholder="请输入学员账号/姓名/单位名称" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords'); ?>">
                </label>
                <button id="click_submit" class="btn btn-blue" type="submit">查询</button>
                <input id="is_excel" type="hidden" name="is_excel" value="0">
            </form>
        </div>
        <!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th></th>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('gf_account'); ?></th>
                        <th><?php echo $model->getAttributeLabel('zsxm'); ?></th>
                        <th><?php echo $model->getAttributeLabel('real_sex'); ?></th>
                        <th><?php echo $model->getAttributeLabel('user_type'); ?></th>
                        <th>单位</th>
                        <?php if ($_REQUEST['index'] == 3||4 ) { ?>
                            <th>申请单位状态</th>
                        <?php } ?>

                        <?php if ($_REQUEST['index'] == 8) { ?>
                            <th>绑定单位状态</th>
                            <th>绑定单位</th>
                        <?php } else { ?>
                            <th><?php echo $model->getAttributeLabel('club_status'); ?></th>
                        <?php } ?>
                        <?php if ($_REQUEST['index'] == 6) { ?>
                            <th>申请解除时间</th>
                            <th>正式解除时间</th>
                        <?php } else { ?>
                            <th><?php echo $date_str; ?></th>
                        <?php } ?>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>222</tr>
                  
                    <?php
                    $index = 1;
                    foreach ($arclist as $v) {
                        ?>
                        <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td> 
                        <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->gf_account; ?></td>
                            <td><?php echo $v->zsxm; ?></td>
                            <td><?php if($v->base_code_sex != null)echo $v->base_code_sex->F_NAME;?></td>
                            <td><?php echo $v->user_type; ?></td>
                            <?php if($_REQUEST['index']==3) { ?>
                                <td><?php echo $v->club_name; ?></td>
                            <?php } elseif($_REQUEST['index']==4){ ?>
                                <td><?php echo $v->apply_kitchen_name; ?></td>
                            <?php } ?>
                            <?php if($_REQUEST['index']==3||4) { ?>
                                <td><?php echo $v->apply_kitchen_status?></td>
                            <?php } ?>
                            <td><?php if(!is_null($v->base_code_status))echo $v->base_code_status->F_NAME;?></td>
                            <td><?php if(!is_null($v->gf_user_1)) echo $v->gf_user_1->REGTIME; else put_msg('nogfuser1');?></td>
                            <td>
                                    <?php echo show_command('修改',$this->createUrl('update', array('id' => $v->id, 'member_gfid' => $v->member_gfid, 'index' => $_REQUEST['index']))); ?>
                            </td>
                        
                    </tr>
                        


                    <?php $index++;} ?>
                </tbody>
            </table>
        </div>

        <div class="box-page c"><?php $this->page($pages); ?></div>

    </div>
</div>
<script>
    function on_exam() {
        $('#index').val(2);
        $('.box-search select').html('<option value>请选择</option>');
        $('.box-search .input-text').val('');
        document.getElementById('click_submit').click();
    }

    function on_exam2() {
        $('#index').val(4);
        $('.box-search select').html('<option value>请选择</option>');
        $('.box-search .input-text').val('');
        document.getElementById('click_submit').click();
    }


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



    function to_revoke_apply(invite_id) {
        var can1 = function() {
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('CancelInvite'); ?>',
                data: {
                    invite_id: invite_id,

                },
                dataType: 'json',
                success: function(data) {
                    if (data.status == 1) {
                        we.success(data.msg, data.redirect);
                    } else {
                        we.msg('minus', data.msg);
                    }
                }
            });
            return false;
        }

        $.fallr('show', {
            buttons: {
                button1: {
                    text: '是',
                    danger: true,
                    onclick: can1
                },
                button2: {
                    text: '否'
                }
            },
            content: '是否撤销邀请？',
            icon: 'trash',
            afterHide: function() {
                we.loading('hide');
            }
        });

    }


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
        to_revoke_apply(str);
        //console.log(str);
    })



    function to_revoke_relieve(id) {
        var can1 = function() {
            $.ajax({
                type: 'get',
                url: '<?php echo $this->createUrl('revoke_relieve'); ?>',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(data) {
                    if (data.status == 1) {
                        we.success(data.msg, data.redirect);
                    } else {
                        we.msg('minus', data.msg);
                    }
                }
            });
            return false;
        }

        $.fallr('show', {
            buttons: {
                button1: {
                    text: '是',
                    danger: true,
                    onclick: can1
                },
                button2: {
                    text: '否'
                }
            },
            content: '是否撤销解除？',
            icon: 'trash',
            afterHide: function() {
                we.loading('hide');
            }
        });

    }


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
        to_revoke_relieve(str);
        //console.log(str);
    })

    //时分秒：
    $(function() {
        var $start_time = $('#start_date');
        var $end_time = $('#end_date');
        $start_time.on('click', function() {
            var end_input = $dp.$('end_date')
            WdatePicker({
                startDate: '%y-%M-%D',
                dateFmt: 'yyyy-MM-dd',
                alwaysUseStartDate: false,
                onpicked: function() {
                    end_input.click();
                },
                maxDate: '#F{$dp.$D(\'end_date\')}'
            });
        });
        $end_time.on('click', function() {
            WdatePicker({
                startDate: '%y-%M-%D',
                dateFmt: 'yyyy-MM-dd',
                alwaysUseStartDate: false,
                minDate: '#F{$dp.$D(\'start_date\')}'
            });
        });
    });

    function excel() {
        $("#is_excel").val(1);
        $("#click_submit").click();
        $("#is_excel").val(0);
    }

    function importfile() {
        $.dialog.open('<?php echo $this->createUrl("upExcel"); ?>', {
            id: 'sensitive',
            lock: true,
            opacity: 0.3,
            title: '导入学员信息',
            width: '60%',
            height: '50%',
            close: function() {
                // window.location.reload(true);
            }
        });
    }
</script>
<!-- <script>
$(function(){
    var $start_time=$('#start_date');
    var $end_time=$('#end_date');
    $start_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
});
</script> -->