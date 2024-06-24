<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>订单列表</h1></div><!--box-title end-->
    <div class="box-content">
    	<div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('create');?>"><i class="fa fa-plus"></i>添加</a>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div>
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div>
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th class="list-id"><?php echo $model->getAttributeLabel('id');?></th>
                        <th><?php echo $model->getAttributeLabel('order_id');?></th>
                        <th><?php echo $model->getAttributeLabel('customer_id');?></th>
                        <th><?php echo $model->getAttributeLabel('kitchen_id');?></th>
                        <th><?php echo $model->getAttributeLabel('amount');?></th>
                        <th><?php echo $model->getAttributeLabel('create_time');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
<?php foreach($arclist as $v){ ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><?php echo CHtml::link(CHtml::encode($v->id), array('update', 'id'=>$v->id)); ?></td>
                        <td><?php echo $v->order_id; ?></td>
                        <td><?php echo $v->customer_id; ?></td>
                        <td><?php echo $v->kitchen_id; ?></td>
                        <td><?php echo $v->amount; ?></td>
                        <td><?php echo $v->create_time; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>
                            <a class="btn" href="<?php echo $this->createUrl('OrderDetail/card', array('orderId'=>$v->order_id));?>" title="查看"><i class="fa fa-file-o"></i></a>
                        </td>
                    </tr>
<?php } ?>
                </tbody>
            </table>
        </div>
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div>
    
</div>
<script>
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
</script>