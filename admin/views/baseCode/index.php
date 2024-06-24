
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>公共部类型</h1></div>
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('create');?>"><i class="fa fa-plus"></i>添加</a>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <!-- <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a> -->
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="news_type" value="<?php echo Yii::app()->request->getParam('news_type');?>">
                <label style="margin-right:10px">
                    <span>关键字：</span>
                    <input type="text" style="width:200px;" class="input-text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入功能名称">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-header end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <!-- <th class="check"><input type="checkbox" id="j-checkall" class="input-check"></th> -->
                        <th style="text-align: center;">序号</th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('F_TCODE');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('F_CODE');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('F_TYPECODE');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('F_NAME');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('F_SHORTNAME');?></th>
                        <th style="text-align: center;">操作</th>
                    </tr>
                </thead>
                <tbody>
<?php 
$index = 1;
foreach($arclist as $v){
?>
                    <tr>
                        <!-- <td class="check check-item"><input type="checkbox" class="input-check" value="<?php echo CHtml::encode($v->f_id);?>"></td> -->
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td style="text-align: center"><?php echo $v->F_TCODE; ?></td>
                        <td style="text-align: center"><?php echo $v->F_CODE; ?></td>
                        <td style="text-align: center"><?php echo $v->F_TYPECODE; ?></td>
                        <td style="text-align: center"><?php echo $v->F_NAME; ?></td>
                        <td style="text-align: center"><?php echo $v->F_SHORTNAME; ?></td>
                        <td style='text-align: center;'>
                            <a class="btn" href="<?php echo $this->createUrl('index2', array('id'=>$v->f_id));?>" title="二级类型">二级类型</a>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->f_id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                        </td>
                    </tr>
<?php $index++;} ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages);?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('f_id'=>'f_id'));?>';
</script>