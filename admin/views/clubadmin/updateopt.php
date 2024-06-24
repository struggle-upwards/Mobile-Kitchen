<html>
<head><link href="./layui/css/layui.css" rel="stylesheet"></head>
<body>
<div class="box">
    <div class="box-title c">
    	<h1><i class="fa fa-table"></i>系统>权限管理><?php echo $tname; ?>授权>授权详情</h1>
		<span class="back">
			<a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a>
		</span>
	</div><!--box-title end-->
    <div class="box-detail">
<?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
<div class="box-detail-bd">
<div style="display:block;" class="box-detail-tab-item">
<table class="mt15">
<?php echo $form->hiddenField($model, 'id', array('class' => 'input-text',)); ?>
<tr>
<td width="10%"><?php echo $form->labelEx($model, 'club_code'); ?></td>
<td width="90%"><?php echo $model->club_code; ?></td>
</tr>
<tr>
	<td ><?php echo $form->labelEx($model, 'club_name'); ?></td>
	<td ><?php echo $model->club_name; ?></td>
</tr>
<tr>
    <td>角色</td>
    <?php   echo readData($form,$model,'role_name:radio(role):0:1'); ?>
</tr>
</tr>

</table>
</div><!--box-detail-tab-item end-->
		</div><!--box-detail-bd end-->
        <div class="box-detail-submit">
			<button class="btn btn-blue" onclick="update()" type="button">确认</button>
			<button class="btn" type="button" onclick="we.back();">取消</button>
		</div>
		<?php $this->endWidget();?>
	</div>
</div>


<script>
var id="<?php echo $model->id;?>";
	//选择框事件

function getRole(){
  var radios = document.getElementsByName("Clubadmin[role_name]");

  var value='';
   for (var i = 0; i < radios.length; i++) {
    if (radios[i].checked) {
        value = radios[i].value;
        break;
      }
    }
    console.log('value',value);
    return value;
}


  function update(){
        var value=getRole();
        console.log(value);
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('updateopt');?>&id='+id,
            data:{id:id,role_name:value},
       //     contentType: 'application/json',
            dataType: 'json',
            success: function(data){
            if (data.status == 1) {
                    we.msg('check', data.msg, function() {
                        we.loading('hide');
                       we.back();
                    });
                } else {
                    we.msg('error', data.msg, function() {
                        we.loading('hide');
                    });
                }
            },
            errer: function(request){
                we.msg('minus','获取错误');
            }
        });
    }

 </script>
</body>
</html>
