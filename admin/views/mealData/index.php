
<div class="box">
    <div class="box-title c">
    <h1>当前界面：订宴管理》宴席管理》<a class="nav-a">
        宴席上架处理</a></h1>
            <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
        </div><!--box-title c end-->
    <div class="box-content">
        <div class="box-header">
            <?php echo show_command('添加',$this->createUrl('create'),'新增上架'); ?>
            <?php echo show_command('批删除','','删除'); ?>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
            <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
            <input type="hidden" name="pricing" value="<?php echo Yii::app()->request->getParam('pricing');?>">
            <label style="margin-right:20px;">
                <span>状态：</span>
                <?php echo downList($state,'F_NAME','F_NAME','state'); ?>
            </label>
            <label style="margin-right:10px;">
                <span>关键字：</span>
                <input style="width:200px;" class="input-text" type="text" name="keywords" placeholder="厨房名称/宴席名称" value="<?php echo Yii::app()->request->getParam('keywords');?>">
            </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
            <tr class="table-title">
                <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                <th width="10%"><?php echo $model->getAttributeLabel('kitchen_code');?></th>
                <th width="15%"><?php echo $model->getAttributeLabel('kitchen_name');?></th>
                <!-- <th ><?php echo $model->getAttributeLabel('meal_code');?></th> -->
                <th ><?php echo $model->getAttributeLabel('meal_name');?></th>
                <th ><?php echo $model->getAttributeLabel('meal_type');?></th>
                <th ><?php echo $model->getAttributeLabel('f_check_name');?></th>
                <th style="text-align:center">操作</th>
            </tr>
                <?php foreach($arclist as $v){ ?>
            <tr>
            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
            <td><?php echo $v->kitchen_code; ?></td>
            <td><?php echo $v->kitchen_name; ?></td>
           <!-- <td><?php echo $v->meal_code; ?></td> -->
           <td><?php echo $v->meal_name; ?></td>
            <td><?php echo $v->meal_type; ?></td>
            <td><?php echo $v->f_check_name; ?></td>
            <td style="text-align:center">
                <a class="btn" href="<?php echo $this->createUrl('updatesee', array('id'=>$v->id));?>" title="查看"><i class="fa fa-edit"></i>查看</a>
            	<a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i>编辑</a>
                <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i>删除</a>       
            </td>
            </tr>
                   <?php } ?>
                </table>
                 
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID')); ?>';
</script>