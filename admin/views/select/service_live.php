<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="service_id" value="<?php echo Yii::app()->request->getParam('service_id');?>">
                <input class="input-text" type="hidden" name="type" value="<?php echo $_GET["type"];?>">
                <input class="input-text" type="hidden" name="club_id" value="<?php echo $_GET["club_id"];?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list product_list">
                <thead>
                    <tr>
                        <th>点击选择</th>
                    </tr>
                </thead>
                <tbody>
<?php foreach($arclist as $v){ ?>
                    <tr class="list-open product_ul" id="product_<?php echo $v->id; ?>" data-id="<?php echo $v->id; ?>" data-name="<?php echo $v->title; ?>" data-code="<?php echo $v->code; ?>">
                        <td class="first"><?php echo $v->title; ?></td>
                    </tr>
                    <?php if(isset($v->video_live_programs) && !empty($v->video_live_programs)){?>
                    <?php foreach($v->video_live_programs as $v2){?>
                    <tr style="display:none;" class="item item_<?php echo $v->id; ?>" data-id="<?php echo $v->id; ?>" data-name="<?php echo $v->title; ?>" data-code="<?php echo $v->code; ?>" data-attrid="<?php echo $v2->id; ?>" data-attr="<?php echo $v2->title; ?>">
                        <td><?php echo $v2->title; ?></td>
                    </tr>
                    <?php }?>
                    <?php }?>
<?php } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
$(function(){
    api = $.dialog.open.api;	// 			art.dialog.open扩展方法
    if (!api) return;

    // 操作对话框
    api.button(
        {
            name: '取消'
        }
    );
    var $product_ul=$('.product_ul');
    var $item=$('.item');
    $product_ul.on('click', function(){
        var $this=$(this);
        var this_id=$this.attr('data-id');
        var is_open;
        $item.hide();
        if($this.hasClass('list-open')){
            $product_ul.removeClass('list-close').addClass('list-open');
            $this.removeClass('list-open').addClass('list-close');
            $('.item_'+this_id).show();
        }else{
            $this.removeClass('list-close').addClass('list-open');
        }
    });
    $('.box-table tr.item').on('click', function(){
        var id=$(this).attr('data-id');
        var code=$(this).attr('data-code');
        var name=$(this).attr('data-name');
		var data_id=$(this).attr('data-attrid');
        var json_attr=$(this).attr('data-attr');
        $.dialog.data('service_id', id);
        $.dialog.data('service_code', code);
        $.dialog.data('service_name', name);
        $.dialog.data('service_data_id', data_id);
        $.dialog.data('service_data_name', json_attr);
        $.dialog.close();
    });
});
</script>