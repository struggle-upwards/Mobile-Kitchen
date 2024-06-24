<?php if($flag==1){
    $txt='编辑';
} else{
    $txt='添加';
}
?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：订宴管理》宴席管理》菜品管理》<a class="nav-a"><?php echo $txt; ?></a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回列表</a></span>
    </div><!--box-title end-->
    <div class="box-detail">
     <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table>
<tr>
    <td width="20%"><?php echo $form->labelEx($model, 'kitchen_code');?></td>
    <?php if($txt == '添加') { ?>
        <td width="80%">
            <!-- 显示 club_code 的值，但不允许编辑 -->
            <?php echo get_session('club_code'); ?>
            <!-- 将 club_code 作为隐藏字段添加到表单中-->
            <?php echo $form->hiddenField($model, 'kitchen_code', array('class' => 'input-text','value' => get_session('club_code'))); ?> 
        </td>
    <?php } else { ?>
        <td width="80%">
            <!-- 显示 kitchen_code 的值，并禁用编辑 -->
            <?php echo $form->textField($model, 'kitchen_code', array('class' => 'input-text', 'disabled' => 'disabled')); ?>
            <?php echo $form->error($model, 'kitchen_code', $htmlOptions = array()); ?>
        </td>
    <?php } ?>
</tr>   
                    <tr>
                        <td width="20%"><?php echo $form->labelEx($model, 'dish_name');?></td>
                        <td width="80%">
                            <?php echo $form->textField($model, 'dish_name', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'dish_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>  
                    <tr>
                        <td><?php echo $form->labelEx($model, 'img_url'); ?></td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'img_url', array('class' => 'input-text fl')); ?>
                            <?php $basepath=BasePath::model()->getPath(189);$picprefix=''; if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->img_url!=''){?>
                                <div class="upload_img f2" id="upload_pic_DishDetail_img_url">
                                    <a href="<?php echo '/Mobile_Kitchen//uploads/temp/'.$model->img_url;?>" target="_blank">
                                        <img src="<?php echo '/Mobile_Kitchen//uploads/temp/'.$model->img_url;?>" width="100">
                                    </a>
                                </div>
                            <?php }?>
                                <script>we.uploadpic('<?php echo get_class($model);?>_img_url','<?php echo $picprefix;?>');</script>
                            <?php echo $form->error($model, 'img_url', $htmlOptions = array()); ?>
                        </td>
                    </tr>   
                    <tr>
                        <td width="20%"><?php echo $form->labelEx($model, 'discription');?></td>
                        <td width="80%">
                            <?php echo $form->textArea($model,'discription', array('class' => 'input-text', 'maxlength'=>'100' )); ?>
                            <p style="color: #999999;">简短介绍，最多可输入100个字符</p>
                            <?php echo $form->error($model, 'discription', $htmlOptions = array()); ?>
                        </td>
                    </tr>      
                </table>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
        <div class="box-detail-submit"><button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button><button class="btn" type="button" onclick="we.back();">取消</button></div>

        <?php $this->endWidget();?>
    </div><!--box-detail end-->
</div><!--box end-->

<script>
    we.tab('.box-detail-tab li','.box-detail-tab-item');
    fnAgreement('#check-1');
    var club_id=0;
    var $game_id=$('#GameNews_game_id');
    $('#game_select_btn').on('click', function(){
        var club_id=$('#GameNews_club_id').val();
        $.dialog.data('game_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/gameList");?>&club_id='+club_id,{
            id:'saishi',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
           close: function () {
                if($.dialog.data('game_id')>0){
                    $game_id.val($.dialog.data('game_id')).trigger('blur');
                    $('#GameNews_news_date_start').val($.dialog.data('star'));
                    $('#GameNews_news_date_end').val($.dialog.data('end'));
                    $('#game_box').html($.dialog.data('game_title'));
                }
            }
        });
    });
    //限制图集简介字数
function LimitText(op){
     maxlimit = 500;
     var textval=$(op).val();
     if (textval.length > maxlimit) {
         $(op).val(textval.substring(0, maxlimit));
         we.msg('minus', '字数不得多于500！');
     }
}
    $('#GameNews_news_date_start').on('click', function(){
    WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});});
    $('#GameNews_news_date_end').on('click', function(){
    WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});});
    var project_id=0;

    // 滚动图片处理
    var $GameNews_game_news_pic=$('#GameNews_game_news_pic');
    var $game_news_pic=$('#game_news_pic');
    var $upload_pic_game_news_pic=$('#upload_pic_game_news_pic');
    var $upload_box_scroll_pic_img=$('#upload_box_scroll_pic_img');

    // 上传完成时图片处理
    var fnscrollPic=function(savename,allpath){
        console.log("123");
        pic_num++;
        $game_news_pic.append('<tr><td width="150"><input type="hidden" name="game_news_pic['+pic_num+'][id]" value="null" ><input type="hidden" name="game_news_pic['+pic_num+'][pic]" value="'+savename+'" ><a class="picbox" data-savepath="'+savename+'" href="'+allpath+'" target="_blank"><img src="'+allpath+'" width="100"></a></td><td><textarea oninput="LimitText(this)" onpropertychange="LimitText(this)" name="game_news_pic['+pic_num+'][intro]" class="input-text" style="width:80%;height:80px;" maxlength="500" placeholder="请输入图片介绍... 500字以内"></textarea></td><td width="50"><a class="btn" href="javascript:;" onclick="fnDelPic(this);" title="删除"><i class="fa fa-trash-o"></i></a>');
    };

    var fnDelPic=function(op){
        $(op).parent().parent().remove();
    }

    selectOnchang('#GameNews_news_type');
    function selectOnchang(obj){
    //     console(obj);
        var show_id=$(obj).val();
        if (show_id==884) {
            $("#show_pic_line").show();
            $("#show_video_line").hide();
            $("#news_content").hide();
        }else if (show_id==885){
            $("#show_video_line").show();
            $("#show_pic_line").hide();
            $("#news_content").hide();
        } else if (show_id==883) {
            $("#show_video_line").hide();
            $("#show_pic_line").hide();
            $("#news_content").show();

        }
    };


$(function(){



        // 添加图片到$model->game_news_pic;
        var arr1=[];
        $upload_pic_game_news_pic.find('a').each(function(){
            arr1.push($(this).attr('data-savepath'));
        });
        $game_news_pic.val(we.implode(',',arr1));
        $upload_box_scroll_pic_img.show();

    // 选择视频
    var $video_box=$('#video_box');
    var $GameNews_news_video=$('#GameNews_news_video');
    $('#video_select_btn').on('click', function(){
        var club_id=$('#GameNews_club_id').val();
        $.dialog.data('video_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/material", array('type'=>253));?>&club_id='+club_id,{
            id:'shipin',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                //console.log($.dialog.data('club_id'));
                if($.dialog.data('material_id')>0){
                    $GameNews_news_video.val($.dialog.data('material_id')).trigger('blur');
                    $video_box.html('<a href="'+$.dialog.data('v_path')+'" target="_blank">'+$.dialog.data('material_title')+'</a>');
                }
            }
        });
    });

});

    //从图库选择图片
var $Single=$('#GameNews_news_pic');
    $('#picture_select_btn').on('click', function(){
        //var club_id=$('#GfSite_user_club_id').val();&club_id='+club_id
        $.dialog.data('app_icon', 0);
        $.dialog.open('<?php echo $this->createUrl("gfMaterial/materialPictureAll", array('type'=>252,'fd'=>189));?>',{
            id:'picture',
            lock:true,
            opacity:0.3,
            title:'请选择素材',
            width:'100%',
            height:'90%',
            close: function () {
                if($.dialog.data('material_id')>0){
                    $Single.val($.dialog.data('app_icon')).trigger('blur');

                    $('#upload_pic_GameNews_news_pic').html('<a href="<?php echo $basepath->F_WWWPATH;?>'+art.dialog.data('app_icon')
                    +'" target="_blank"> <img src="<?php echo $basepath->F_WWWPATH;?>'+art.dialog.data('app_icon')
                    +'"  width="100"></a>');

                   // $('#Gfapp_app_icon_x').val($.dialog.data('dataX')).trigger('blur');
                    //$('#Gfapp_app_icon_y').val($.dialog.data('dataY')).trigger('blur');
                    //$('#Gfapp_app_icon_w').val($.dialog.data('dataWidth')).trigger('blur');
                    //$('#Gfapp_app_icon_h').val($.dialog.data('dataHeight')).trigger('blur');
               }

            }
        });
});
</script>
