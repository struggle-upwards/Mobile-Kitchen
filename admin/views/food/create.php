<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>编辑订单</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list('baocun')); ?>
        <table>
            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'food_id'); ?></td>
                <td width="35%">
                    <?php echo $form->textField($model, 'food_id', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'food_id', $htmlOptions = array()); ?>
                </td>
                <td width="15%"><?php echo $form->labelEx($model, 'food_name'); ?></td>
                <td width="35%">
                    <?php echo $form->textField($model, 'food_name', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'food_name', $htmlOptions = array()); ?>
                </td>           
            </tr>
            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'price'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'price', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'price', $htmlOptions = array()); ?>
                </td>
                <td width="15%"><?php echo $form->labelEx($model, 'count'); ?></td>
                <td width="35%">
                    <?php echo $form->textField($model, 'count', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'count', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'status'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'status', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'status', $htmlOptions = array()); ?>
                </td>
            </tr>
            
        </table>
        <div class="box-detail-submit">

        <?php echo show_shenhe_box(array('baocun'=>'保存'));?>
        <button class="btn" type="button" onclick="we.back();">取消</button></div>
        <?php $this->endWidget(); ?>
    </div>
</div>
