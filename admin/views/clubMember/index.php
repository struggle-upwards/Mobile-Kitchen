
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>学员申请表</h1></div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <!-- <a class="btn" href="<?php //echo $this->createUrl('create');?>"><i class="fa fa-plus"></i>添加</a> -->
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
            
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="news_type" value="<?php echo Yii::app()->request->getParam('news_type');?>">

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
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style='text-align: center;'>序号</th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('gf_account');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('zsxm');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('real_sex');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('member_project_id');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('agree_state_name');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('club_id');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('member_level_register_time');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('start_time');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('uDate');?></th>
                        <th style='text-align: center;'>操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php $basepath=BasePath::model()->getPath(130);?>
<?php 
$index = 1;
foreach($arclist as $v){ 
?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td style='text-align: center;'><?php echo $v->gf_account; ?></td>
                        <td style='text-align: center;'><?php echo $v->zsxm; ?></td>
                        <td style='text-align: center;'><?php if($v->base_code_sex!=null){ echo $v->base_code_sex->F_NAME; } ?></td>
                        <td style='text-align: center;'><?php if($v->project_list!=null){ echo $v->project_list->project_name; } ?></td>
                        <td style='text-align: center;'><?php echo $v->agree_state_name; ?></td>
                        <td style='text-align: center;'><?php if($v->club_list!=null){ echo $v->club_list->club_name; } ?></td>
                        <td style='text-align: center;'><?php echo $v->member_level_register_time; ?></td>
                        <td style='text-align: center;'><?php echo $v->start_time; ?></td>
                        <td style='text-align: center;'><?php echo $v->uDate; ?></td>
                        <td style='text-align: center;'>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>

                        </td>
                    </tr>
<?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        
        <div class="box-page c"><?php $this->page($pages);?></div>
        
    </div><!--box-content end-->
</div><!--box end-->
<script>
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
</script>
