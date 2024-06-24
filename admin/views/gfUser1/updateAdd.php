<?php


?>
<html>
<head>
	<link href="admin/views/Clubadmin/layui/css/layui.css" rel="stylesheet">

</head>
<body>

<div class="box">
    <div class="box-title c">
    	<h1><i class="fa fa-table"></i>系统>权限管理>小程序账号授权>授权详情</h1>
		<span class="back">
			<a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a>
		</span>
	</div><!--box-title end-->
    <div class="box-detail">
     	<?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
			<div style="display:block;" class="box-detail-tab-item">
				<table class="mt15">
					<?php echo $form->hiddenField($model, 'GF_ID', array('class' => 'input-text',)); ?>
					<tr>
						<td width="10%"><?php echo $form->labelEx($model, 'security_phone'); ?></td>
						<td width="90%">
							<?php echo $form->textField($model, 'security_phone', array('class' => 'input-text','readonly'=>'ture','style'=>'width:200px;')); ?>
							<?php if(isset($isNew)){ ?>
							<input id="club_select_btn" class="btn" type="button" onclick="read_person()" value="选择">
							<?php }; ?>
							<?php echo $form->error($model, 'security_phone', $htmlOptions = array()); ?>
						</td>
					</tr>

					<tr>
						<td ><?php echo $form->labelEx($model, 'GF_NAME'); ?></td>
						<td >
							<?php echo $form->textField($model, 'GF_NAME', array('class' => 'input-text','readonly'=>'ture','style'=>'width:200px;')); ?>
							<?php echo $form->error($model, 'GF_NAME', $htmlOptions = array()); ?>
						</td>
					</tr>
					<tr>
					
					<tr>
						<td><?php echo $form->labelEx($model, 'roleName'); ?></td>
						<td style="width:100%">
							<div class="layui-form">
  								<select lay-filter="demo-select-filter">
    							<option value="<?php echo $model->roleCode;?>">请选择</option>
    							<?php foreach($roles['first'] as $k=>$v){ ?>
    								<optgroup label="<?php echo $v;?>">
    									<?php foreach($roles['second'][$k] as $k2=>$v2){ 
    										if($v2->f_id==$model->roleCode){
    									?>
    									<option value="<?php echo $v2->f_id;?>" selected>
      									<?php echo $v.'-'.$v2->f_rname;?>
      									</option>
      									<?php
    										}
    										else{
    									?>
    									<option value="<?php echo $v2->f_id;?>">
      									<?php echo $v.'-'.$v2->f_rname;?>
      									</option>
    									<?php
    										};
    									?>

      								<?php } ?>
    							</optgroup>
    							<?php } ?>
  								</select>
							</div>
						</td>
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

<script src="admin/views/Clubadmin/layui/layui.js"></script> 
<script>
	var f_id="<?php echo $model->roleCode;?>";
	//选择框事件
	layui.use(function(){
    var form = layui.form;
    var layer = layui.layer;
    // select 事件
    form.on('select(demo-select-filter)', function(data){
     f_id=data.value;
    //layer.msg(this.innerHTML + ' 的 value: '+ data.value); // this 为当前选中 <option> 元素对象
    });
});
function update(){
		let url = '';
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('updateAdd',array('id'=>$model->GF_ID));?>&f_id='+f_id,
            data:{},
            contentType: 'application/json',
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
