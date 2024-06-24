<div class="box">
    <div class="box-title c">
        <h1>当前界面：订宴管理》<a class="nav-a">宴席详情</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end-->
    <div class="box-detail">
       <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
       <div class="box-detail-bd">
        <div style="display:block;" class="box-detail-tab-item">
            <table class="table-title">
                <tr><td>方案信息</td> </tr>
            </table>
            <table>
                <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'kitchen_code'); ?></td>
                <td  width="35%"><?php echo $model->kitchen_code;?></td>

                <!-- <?php //echo readData($form,$model,"supplier_id:hidden","0");?> -->

                 <td  width="15%"><?php echo $form->labelEx($model, 'kitchen_name'); ?></td>
                <td  width="35%"><?php echo $model->kitchen_name;?></td>
                </tr> 
                <tr>
                    <td><?php echo $form->labelEx($model, 'meal_name'); ?></td>
                    <td colspan="3"><?php echo $model->meal_name;?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'meal_type'); ?></td>
                    <td><?php echo $model->meal_type;?></td>
                    <td><?php echo $form->labelEx($model, 'price'); ?></td>
                    <td><?php echo $model->price;?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'description'); ?></td>
                    <td colspan="3"><?php echo $model->description;?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'meal_img_url'); ?></td>
                    <td colspan="3">
                        <?php $basepath="/Mobile_Kitchen//uploads/temp/";?>
                        <a href="<?php echo $basepath.$model->meal_img_url; ?>" target="_blank">
                            <img src="<?php echo $basepath.$model->meal_img_url; ?>" style="max-height:100px; max-width:100px;">
                        </a>
                    </td>

                </tr>
            </table>

            <table class="table-title">
                <tr><td>菜品信息</td> </tr>
            </table>
            <table id="product0">
            <tr>
                <td width="20%">编号</td> 
                <td width="80%">菜品名称</td> 
            </tr>
            <?php 
                $index=1;
                foreach($dishes as  $d) { 
            ?> 
                <tr>
                    <td><?php echo $index;?></td>
                    <td><?php echo $d->dish_name;?></td>
                </tr>
            <?php 
                $index++;} 
            ?> 
            </table>

            <table  class="table-title">
                <tr><td>审核</td> </tr>
            </table>
            <table>
                <tr>
                    <td><?php echo $form->labelEx($model, 'f_check_name'); ?></td>
                    <td colspan="3"><?php echo $model->f_check_name;?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'reasons_for_failure'); ?></td>
                    <td colspan="3"><?php echo $model->reasons_for_failure;?></td>
                </tr>
            </table>
        </div>
    </div><!--box-detail-bd end-->
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->