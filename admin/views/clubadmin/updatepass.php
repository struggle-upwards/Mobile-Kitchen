<?php
    if (isset( $_REQUEST['lang_type'] ) ) {
       $model->lang_type=$_REQUEST['lang_type'];//角色类型
    } 
    if ($model->lang_type>0) $model->club_id=get_session('club_id');
		$da=array("club_id"=>get_session("club_id"),"project_id"=>"0","code_type"=>"GL");
		$tname= (($model->lang_type==0) ?'平台单位' : get_session('club_name').'用户');
	if(empty($model->id)){
		$model->admin_gfaccount=" ";
	}
?>
<html>
<head><link href="./layui/css/layui.css" rel="stylesheet"></head>
<body>

<div class="box">
    <div class="box-title c">
    	<h1><i class="fa fa-table"></i>系统>权限管理><?php echo $tname; ?>授权>密码修改</h1>
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
						<td width="90%">
							<?php echo $model->club_code; ?>
						</td>
					</tr>
					<tr>
						<td ><?php echo $form->labelEx($model, 'club_name'); ?></td>
						<td >
							<?php echo $model->club_name; ?>
						</td>
					</tr>
			
					<tr>
						<td><?php echo $form->labelEx($model, 'password'); ?></td>
						<td id='funpsd'>
							<?php $password = empty($model->password) ? '123456' : $model->password; ?>
							<input class="input-text" type="password" style="width:200px;" name="Clubadmin[password]" id="Clubadmin_password" value="<?php echo $password; ?>" autocomplete="off">
							<span class="msg">注：默认登录密码为123456，添加成功后请尽快前往更新登录密码</span>
						</td>
					</tr>
				</table>
			</div><!--box-detail-tab-item end-->
		</div><!--box-detail-bd end-->
        <div class="box-detail-submit">
			<?php echo $form->textField($model, 'admin_gfid', array('class' => 'input-text','hidden'=>'ture')); ?>
			<?php echo $form->textField($model, 'club_id', array('class' => 'input-text','hidden'=>'ture')); ?>
			<?php echo $form->textField($model, 'lang_type', array('class' => 'input-text','hidden'=>'ture')); ?>
			<button class="btn btn-blue" onclick="update()" type="button">确认</button>
			<button class="btn" type="button" onclick="we.back();">取消</button>
		</div>
		<?php $this->endWidget();?>
	</div>
</div>

<script src="./layui/layui.js"></script> 
<script>
	var f_id="<?php echo $model->admin_level;?>";
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


	
 </script>
</body>
</html>
