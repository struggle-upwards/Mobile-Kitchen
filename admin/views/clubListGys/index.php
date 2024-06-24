<div class="box">
    <div class="box-title c">
      <h1>供应商列表</h1></div><!--box-title end-->
    <div class="box-content">
    	<div class="box-header">
            <?php if(!empty($_REQUEST['club_type'])&&$_REQUEST['club_type']==380){?>
                <?php echo show_command('添加',$this->createUrl('create',array('club_type'=>$_REQUEST['club_type'])),'添加供应商'); ?>
            <?php }else{?>
                <a class="btn" href="<?php echo $this->createUrl('create');?>"><i class="fa fa-plus"></i>添加单位</a>
            <?php }?>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-search">
<form action="<?php echo Yii::app()->request->url;?>" method="get">
<input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
<input type="hidden" name="club_type" value="<?php echo Yii::app()->request->getParam('club_type');?>">
<label style="margin-right:20px;">
    <span>状态：</span>
    <select name="state">
        <option value="">请选择</option>
        <?php foreach($base_code as $v){?>
        <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('state')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
        <?php }?>
    </select>
</label>
<label style="margin-right:20px;">
    <span>供应商类别：</span>
    <select name="type" id="type">
        <option value="">请选择</option>
        <?php foreach($partnertype as $v){?>
        <option value="<?php echo $v->f_id; ?>"<?php if(Yii::app()->request->getParam('type')!=null && Yii::app()->request->getParam('type')==$v->f_id){ ?> selected<?php } ?>><?php echo $v->F_NAME;?></option>
        <?php } ?>
    </select>
</label>
<label style="margin-right:20px;">
    <span>服务地区：</span>
    <select name="province"></select><select name="city"></select><select name="area"></select>
    <script>new PCAS("province","city","area","<?php echo Yii::app()->request->getParam('province');?>","<?php echo Yii::app()->request->getParam('city');?>","<?php echo Yii::app()->request->getParam('area');?>");</script>
</label>
                <br>
                <label style="margin-right:10px;">
                    <span>创办时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo Yii::app()->request->getParam('start_date');?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo Yii::app()->request->getParam('end_date');?>">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
            
    <thead>
        <tr>
            <th class="check" style="text-align:center;"><input id="j-checkall" class="input-check" type="checkbox"></th>
            <?php 
              $rs= $model->gysAttributeLabels();
             echo $rs[0];
            ?>
           <th style="text-align:center;width:100px">操作</th>
                    </tr>
                </thead>
                <tbody>
              		<?php $index=1;foreach($arclist as $v){ ?>
                    <tr> 	
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>  
                        <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <?php
                           foreach($rs[1] as $v1){
                             echo '<td>'.$v->club_code.'</td>';
                           }
                        ?>
                         <td>
                            <?php echo show_command('修改',$this->createUrl('update', array('id'=>$v->id))); ?>
                            <?php echo show_command('删除','\''.$v->id.'\''); ?>
                        </td>
                    </tr>
					<?php $index++; }?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID')); ?>';
</script>
<script>
$(function(){
    var $start_time=$('#start_date');
    var $end_time=$('#end_date');
    $start_time.on('click', function(){
        var end_input=$dp.$('end_date')
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false,onpicked:function(){end_input.click();},maxDate:'#F{$dp.$D(\'end_date\')}'});
    });
    $end_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false,minDate:'#F{$dp.$D(\'start_date\')}'});
    });
});
</script>