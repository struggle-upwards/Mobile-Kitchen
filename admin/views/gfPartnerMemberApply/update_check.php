

<div class="box">

    <<div class="box-title c">
        <h1>当前界面：社区单位》社区管理》社区审核》<a class="nav-a">审核</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回上一层</a></span>
    </div><!--box-title end-->


    <div class="box-detail">

    <?php $form = $this->beginWidget('CActiveForm', get_form_list('baocun')); ?> 

    <div class="box-detail-bd">
            <table>

                <tr class="table-title">
                    <td colspan="4" style="font-size: 15px;font-weight: bold;">社区基本信息</td>
                </tr>

                <tr>
                <?php setbkcolor(0);//控制字段名是否添加底色，0不添加，1添加?>
                <?php echo readData($form,$model,'gf_account:label');?>
                <?php echo readData($form,$model,'club_name:label');?>
                </tr>

                <tr>
                <?php echo readData($form,$model,'apply_club_code:label');?>
                <?php echo readData($form,$model,'apply_club_name:label');?>
                </tr>

                <tr>
                <?php echo readData($form,$model,'zsxm:label');?>
                <?php echo readData($form,$model,'sex:label');?>
                </tr>
                <tr>
                <?php echo readData($form,$model,'apply_phone:label');?>
                <?php echo readData($form,$model,'id_card:label');?>
                </tr>

                <tr>
                    <?php echo readData($form,$model,'type:label');?>
                    <?php echo readData($form,$model,'club_address:label:1:1');?>
                </tr>


                <tr style="display: none;">
                    <?php echo readData($form,$model,'club_logo:1:3:pic');?>
                </tr>

                <tr>
                <td><?php echo $form->labelEx($model, 'id_card_face'); ?></td>
                <td colspan="1">
                        <?php if(!empty($model->id_card_face)){?>
                            <?php $basepath="/Mobile_Kitchen//uploads/temp/";?>
                            <img src="<?php echo  $basepath.$model->id_card_face;?>" width="100" height="80">
                        <?php } else{?>
                            暂未上传图片
                        <?php }?>
                </td>
                <td><?php echo $form->labelEx($model, 'id_card_back'); ?></td>
                <td colspan="1">
                        <?php if(!empty($model->id_card_back)){?>
                            <?php $basepath="/Mobile_Kitchen//uploads/temp/";?>
                            <img src="<?php echo  $basepath.$model->id_card_back;?>" width="100" height="80">
                        <?php } else{?>
                            暂未上传图片
                        <?php }?>
                </td>

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