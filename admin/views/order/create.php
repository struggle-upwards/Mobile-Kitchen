<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>新增订单</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list('baocun')); ?>
        <table class="table-title">
            <tr>
                <td>订单信息</td>
            </tr>
        </table>
        <table>
            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'order_id'); ?></td>
                <td width="35%">
                    <?php echo $form->textField($model, 'order_id', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'order_id', $htmlOptions = array()); ?>
                </td>
                <td width="15%"><?php echo $form->labelEx($model, 'customer_id'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'customer_id', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'customer_id', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'kitchen_id'); ?></td>
                <td width="35%">
                    <?php echo $form->textField($model, 'kitchen_id', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'kitchen_id', $htmlOptions = array()); ?>
                </td>
                <td width="15%"><?php echo $form->labelEx($model, 'amount'); ?></td>
                <td width="35%">
                    <?php echo $form->textField($model, 'amount', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'amount', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'create_time'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'create_time', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'create_time', $htmlOptions = array()); ?>
                </td>
            </tr>
            
        </table>
        <div class="box-detail-submit">

        <?php echo show_shenhe_box(array('baocun'=>'保存'));?>
        <button class="btn" type="button" onclick="we.back();">取消</button></div>
        <?php $this->endWidget(); ?>
    </div>
</div>
