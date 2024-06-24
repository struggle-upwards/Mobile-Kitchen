

<div class="box">

    <<div class="box-title c">
        <h1>当前界面：社区单位》社区管理》社区审核》<a class="nav-a">审核</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回上一层</a></span>
    </div><!--box-title end-->


    <div class="box-detail">

    <?php $form = $this->beginWidget('CActiveForm', get_form_list('baocun')); ?> 

    <div class="box-detail-bd">
            <table class="detail product_publish_content" border="1" cellspacing="1" cellpadding="0" style="color:#555;margin-bottom:10px;">
                <!--固定部分-->
                <tr>
                    <td style="padding:10px;background:#efefef;" colspan="4" >申请信息</td>
                </tr>
                <tr>
                    <td style="padding:10px;" width="15%"><?php echo $form->labelEx($model, 'gf_account'); ?></td>
                    <td style="padding:10px;" width="35%" id="d_gf_account">
                        <?php echo $form->textField($model, 'gf_account', array('class' => 'input-text',)); ?>
                        <?php echo $form->error($model, 'gf_account', $htmlOptions = array()); ?>
                    </td>
                    <!-- <td style="text-align:center;"> <?php echo $model->gf_account ?> </td> -->
                    <td style="padding:10px;"><?php echo $form->labelEx($model, 'club_id'); ?></td>
                    <td style="padding:10px;">
                        <span id="club_box"><?php if($model->club_list!=null){?><span class="label-box"><?php echo $model->club_list->club_name;?><?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text')); ?></span><?php } else {?><span class="label-box"><?php echo get_session('club_name');?><?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text','value'=>get_session('club_id'))); ?></span><?php } ?></span>
                        <?php echo $form->error($model, 'club_id', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding:10px;" width="15%"><?php echo $form->labelEx($model, 'apply_club_code'); ?></td>
                    <td style="padding:10px;" width="35%" id="d_apply_club_code">
                        <?php echo $form->textField($model, 'apply_club_code', array('class' => 'input-text',)); ?>
                        <?php echo $form->error($model, 'apply_club_code', $htmlOptions = array()); ?>
                    </td>
                    <td style="padding:10px;" width="15%"><?php echo $form->labelEx($model, 'apply_club_name'); ?></td>
                    <td style="padding:10px;" width="35%" id="d_apply_club_name">
                        <?php echo $form->textField($model, 'apply_club_name', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'apply_club_name', $htmlOptions = array()); ?>
                    </td> 
                </tr>
                <tr>
                    <td style="padding:10px;" width="15%"><?php echo $form->labelEx($model, 'zsxm'); ?></td>
                    <td style="padding:10px;" width="35%" id="d_zsxm">
                        <?php echo $form->textField($model, 'zsxm', array('class' => 'input-text',)); ?>
                        <?php echo $form->error($model, 'zsxm', $htmlOptions = array()); ?>
                    </td>
                    <td style="padding:10px;" width="15%"><?php echo $form->labelEx($model, 'sex'); ?></td>
                    <td style="padding:10px;" width="35%" id="sex">
                        <?php echo $form->textField($model, 'sex', array('class' => 'input-text',)); ?>
                        <?php echo $form->error($model, 'sex', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding:10px;" width="15%"><?php echo $form->labelEx($model, 'apply_phone'); ?></td>
                    <td style="padding:10px;" width="35%" id="d_apply_phone">
                        <?php echo $form->textField($model, 'apply_phone', array('class' => 'input-text',)); ?>
                        <?php echo $form->error($model, 'apply_phone', $htmlOptions = array()); ?>
                    </td>
                    <td style="padding:10px;" width="15%"><?php echo $form->labelEx($model, 'id_card'); ?></td>
                    <td style="padding:10px;" width="35%" id="id_card">
                        <?php echo $form->textField($model, 'id_card', array('class' => 'input-text',)); ?>
                        <?php echo $form->error($model, 'id_card', $htmlOptions = array()); ?>
                    </td>
                </tr>

                <tr>
                    <td style="padding:10px;" width="15%"><?php echo $form->labelEx($model, 'type'); ?></td>
                    <td style="padding:10px;" width="35%" id="d_type">
                        <?php echo $form->dropDownList($model, 'type', Chtml::listData(BaseCode::model()->getCode(1402), 'f_id', 'F_NAME'), array('prompt'=>'请选择','onchange' =>'selectOnchang(this)')); ?>
                        <?php echo $form->error($model, 'type', $htmlOptions = array()); ?>
                    </td> 
                    <td style="padding:10px;" width="15%"><?php echo $form->labelEx($model, 'apply_address'); ?></td>
                    <td style="padding:10px;" width="35%" id="apply_address">
                        <?php echo $form->textField($model, 'apply_address', array('class' => 'input-text',)); ?>
                        <?php echo $form->error($model, 'apply_address', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding:10px;" width="15%"><?php echo $form->labelEx($model, 'id_card_face'); ?></td>
                    <td >
                            <?php echo $form->hiddenField($model, 'id_card_face', array('class' => 'input-text fl')); ?>
                            <?php $basepath=BasePath::model()->getPath(189);$picprefix=''; if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->id_card_face!=''){?>
                                 <div class="upload_img f1" id="upload_pic_gfPartnerMemberApply_id_card_face">
                                    <a href="<?php echo '/Mobile_Kitchen//uploads/temp/'.$model->id_card_face;?>" target="_blank">
                                        <img src="<?php echo '/Mobile_Kitchen//uploads/temp/'.$model->id_card_face;?>" width="100">
                                    </a>
                                </div> 
                            <?php }?>
                                <script>we.uploadpic('<?php echo get_class($model);?>_id_card_face','<?php echo $picprefix;?>');</script>
                            <?php echo $form->error($model, 'id_card_face', $htmlOptions = array()); ?>
                    </td>
                    <td style="padding:10px;" width="15%"><?php echo $form->labelEx($model, 'id_card_back'); ?></td>
                    <td >
                        <?php echo $form->hiddenField($model, 'id_card_back', array('class' => 'input-text fl')); ?>
                        <?php $basepath=BasePath::model()->getPath(174);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                        <script>we.uploadpic('<?php echo get_class($model);?>_id_card_back','<?php echo $picprefix;?>');</script>
                        <?php echo $form->error($model, 'id_card_back', $htmlOptions = array()); ?>
                    </td>
                </tr>


<!--                 <tr>
                    <td width="15%" style="padding:10px;" ><?php echo $form->labelEx($model, 'code'); ?></td>
                    <td width="35%" style="padding:10px;" id="d_state_certificate_code"><?php echo $model->code;?></td>
                    <td width="15%" style="padding:10px;" ><?php echo $form->labelEx($model, 'member_type_name'); ?></td>
                    <td width="35%" id="dcom_member_type_name">
                        <?php echo $form->textField($model, 'member_type_name', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'member_type_name', $htmlOptions = array()); ?>
                    </td>
                </tr> -->

            </table>

                



        <div class="box-detail-submit">
            <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>
            <button class="btn" type="button" onclick="we.back();">取消</button>
        </div>

    </div><!--box-detail-bd end-->

    <?php $this->endWidget(); ?>

    </div><!--box-detail end-->

</div><!--box end-->