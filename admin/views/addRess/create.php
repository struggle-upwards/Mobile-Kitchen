<div class="box">
    <div class="box-title c">
        <h1>当前界面：xx管理》地址列表》地址添加</h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回列表</a></span>
    </div><!--box-title end-->
    <div class="box-detail">
     <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table>
                    <tr>
                        <td ><?php echo $form->labelEx($model, 'gf_account');?></td>
                        <td >
                            <?php echo $form->textField($model, 'gf_account', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'gf_account', $htmlOptions = array()); ?>
                        </td>
                        <td ><?php echo $form->labelEx($model, 'isDefault');?></td>
                        <td colspan="1">
                            <?php echo $form->textField($model, 'isDefault', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'isDefault', $htmlOptions = array()); ?>
                        </td>

                    </tr>  
                    
                    <tr>
                        <td ><?php echo $form->labelEx($model, 'name'); ?></td>
                        <td >
                             <?php echo $form->textField($model, 'name', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'name', $htmlOptions = array()); ?>
                        </td>
                        <td ><?php echo $form->labelEx($model, 'phone'); ?></td>
                        <td colspan="1">
                            <?php echo $form->textField($model, 'phone', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'phone', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td rowspan="2"><?php echo $form->labelEx($model, 'ads_detail'); ?></span></td>
                        <td colspan="3">
                            <label style="margin-right:20px;">
                                <select name="province"></select><select name="city"></select><select name="district"></select> 
                                <script>
                                    new PCAS("province", "city", "district", "<?php echo $province; ?>", "<?php echo $city; ?>", "<?php echo $district; ?>");
                                </script>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <?php echo $form->textArea($model,'ads_detail', array('class' => 'input-text', 'maxlength'=>'50' )); ?>
                            <?php echo $form->error($model, 'ads_detail', $htmlOptions = array()); ?>
                        </td>
                    </tr>      
                </table>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
        <div class="box-detail-submit"><button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button><button class="btn" type="button" onclick="we.back();">取消</button></div>

        <?php $this->endWidget();?>
    </div><!--box-detail end-->
</div><!--box end-->



