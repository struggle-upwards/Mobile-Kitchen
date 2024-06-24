<div class="box">

    <div class="box-title c">
        <h1>当前界面：培训/活动》活动发布》活动审核》<a class="nav-a">审核</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回上一层</a></span>
    </div><!--box-title end-->

    <div class="box-detail">

    <?php $form = $this->beginWidget('CActiveForm', get_form_list('baocun')); ?>

    <div class="box-detail-bd">
            <table>

                <tr class="table-title">
                    <td colspan="4" style="font-size: 15px;font-weight: bold;">活动基本信息</td>
                </tr>

                <tr>
                <?php setbkcolor(0);//控制字段名是否添加底色，0不添加，1添加?>
                <?php echo readData($form,$model,'activity_code:label');?>
                <?php echo readData($form,$model,'activity_club_name:label');?>
                </tr>

                <tr>
                <?php echo readData($form,$model,'activity_title:label');?>
                <?php echo readData($form,$model,'activity_address:label');?>
                </tr>
                <tr>
                    <td>报名时间</td>
                    <td><?php echo $model->sign_up_date."~".$model->sign_up_date_end;?></td>
                    <td>活动时间</td>
                    <td><?php echo $model->activity_time."~".$model->activity_time_end;?></td>
                </tr>

                <tr>
                <?php echo readData($form,$model,'local_men:label');?>
                <?php echo readData($form,$model,'local_and_phone:label');?>
                </tr>

                <tr>
                <?php echo readData($form,$model,'activity_cost:label');?>
                <?php echo readData($form,$model,'enrole_num:label');?>
                </tr>

                <tr>
                <?php echo readData($form,$model,'activity_content:label:1:3');?>
                </tr>

                <tr>
                <td><?php echo $form->labelEx($model, 'activity_small_pic'); ?></td>
                <td>
                <?php if(!empty($model->activity_small_pic)){?>
                <a href="<?php echo $model->activity_small_pic?>" target="_blank">
                    <img src="<?php echo $model->activity_small_pic?>" width="200" height="100">
                </a>
                <?php } else{?>
                    暂未上传图片
                <?php }?>
                </td>
                <td><?php echo $form->labelEx($model, 'activity_big_pic'); ?></td>
                <td>
                <?php if(!empty($model->activity_big_pic)){?>
                <a href="<?php echo $model->activity_big_pic?>" target="_blank">
                    <img src="<?php echo $model->activity_big_pic?>" width="200" height="100">
                </a>
                <?php } else{?>
                    暂未上传图片
                <?php }?>
                </td>
                </tr>

                <tr>
                <?php echo readData($form,$model,'reasons_for_failure:1:3');?>
                </tr>

            </table>

        <div class="box-detail-submit">
            <button onclick="submitType='pass'" class="btn btn-blue" type="submit">审核通过</button>
            <button onclick="submitType='notpass'" class="btn btn-blue" type="submit">审核不通过</button>
            <button class="btn" type="button" onclick="we.back();">取消</button>
        </div>

    </div><!--box-detail-bd end-->

    <?php $this->endWidget(); ?>

    </div><!--box-detail end-->

</div><!--box end-->
<script>
    function tongguo(modelid){ 
    var s1 = '<?php echo $this->createUrl("GfSite/Tongguo");?>';
        $.ajax({ 
        type: 'get',
        url: s1,
        data: {modelid:modelid},
        dataType:'json',
        success: function(data) {
        window.location.href = "<?php echo $this->createUrl('GfSite/Indexcheck');?>";
       },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.log(XMLHttpRequest);
       }
    });
}
</script>