<div class="box">

    <div class="box-title c">
    <?php if($sign == 'create'){ ?>
        <h1>当前界面：活动/培训》活动发布》发布活动》<a class="nav-a">添加</a></h1>
    <?php } elseif($sign == 'update'){?>
        <h1>当前界面：活动/培训》活动发布》发布活动》<a class="nav-a">编辑</a></h1>
    <?php } ?>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回上一层</a></span>
    </div><!--box-title end-->

    <div class="box-detail">

    <?php $form = $this->beginWidget('CActiveForm', get_form_list('baocun')); ?> 

    <div class="box-detail-bd">
            <table>

                <tr class="table-title">
                    <td colspan="4" style="font-size: 15px;font-weight: bold;">活动基本信息</td>
                </tr>

            <?php if($sign == 'create'){ ?>
                <tr>
                <td>活动编号</td>
                <td style="text-align: center;"><?php echo $siteCode;?></td>
                <td>发布单位</td>
                <td style="text-align: center;"><?php echo $clubName;?></td>
                </tr>
            <?php } elseif($sign == 'update'){?>
                <tr>
                    <?php echo readData($form,$model,'activity_code:readonly');?>
                    <?php echo readData($form,$model,'activity_club_name:readonly');?>
                </tr>
            <?php } ?>

                <tr>
                    <?php setbkcolor(0);//控制字段名是否添加底色，0不添加，1添加?>
                    <?php echo readData($form,$model,'activity_title');?>
                    <?php echo readData($form,$model,'activity_address');?>
                </tr>

                <td>报名时间</td>
                <td>
                    <?php echo $form->textField($model, 'sign_up_date', array('class'=>'input-text','style'=>'width:130px;','placeholder'=>'报名开始时间','id'=>'datePick1')) ; ?>
                    -
                    <?php echo $form->textField($model, 'sign_up_date_end', array('class'=>'input-text','style'=>'width:130px;','placeholder'=>'报名截止时间','id'=>'datePick2')) ; ?>
                    <?php echo $form->error($model, 'sign_up_date', $htmlOptions = array()); ?>
                    <?php echo $form->error($model, 'sign_up_date_end', $htmlOptions = array()); ?>
                </td>

                <td>活动时间</td>
                <td>
                    <?php echo $form->textField($model, 'activity_time', array('class'=>'input-text','style'=>'width:130px;','placeholder'=>'活动开始时间','id'=>'datePick3')) ; ?>
                    -
                    <?php echo $form->textField($model, 'activity_time_end', array('class'=>'input-text','style'=>'width:130px;','placeholder'=>'活动截止时间','id'=>'datePick4')) ; ?>
                    <?php echo $form->error($model, 'activity_time', $htmlOptions = array()); ?>
                    <?php echo $form->error($model, 'activity_time_end', $htmlOptions = array()); ?>
                </td>

                <tr>
                    <?php echo readData($form,$model,'local_men');?>
                    <?php echo readData($form,$model,'local_and_phone');?>
                </tr>

                <tr>
                    <?php echo readData($form,$model,'activity_small_pic:pic');?>
                    <?php echo readData($form,$model,'activity_big_pic:pic');?>
                </tr>

                <tr>
                    <?php echo readData($form,$model,'activity_cost');?>
                    <?php echo readData($form,$model,'enrole_num');?>
                </tr>

                <tr>
                    <?php echo readData($form,$model,'activity_content:HTML:1:3:300:1000');?>
                </tr>

                </table> 

        <div class="box-detail-submit">
            <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>
            <button class="btn" type="button" onclick="we.back();">取消</button>
        </div>

    </div><!--box-detail-bd end-->

    <?php $this->endWidget(); ?>

    </div><!--box-detail end-->

</div><!--box end-->
<script>
var wp = function(){
    WdatePicker({
        startDate:'%y-%M-%D 00:00:00', 
        dateFmt:'yyyy-MM-dd HH:mm:ss'
    }); 
}
$("#datePick1").click(wp);
$("#datePick2").click(wp);
$("#datePick3").click(wp);
$("#datePick4").click(wp);
</script> 