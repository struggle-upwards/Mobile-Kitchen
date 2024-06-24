<!doctype html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="zh-cn"><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" lang="zh-cn"><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9" lang="zh-cn"><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="zh-cn"><!--<![endif]-->
<head>
    <meta charset="utf-8">
    <title><?php echo '花螺上报系统' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge，chrome=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <?php $cs = Yii::app()->clientScript;
    $s1=Yii::app()->request->baseUrl . '/static/admin/';?>
    <?php $cs->registerCoreScript('jquery');?>
    <?php $cs->registerScriptFile($s1.'js/jquery.nicescroll.js');?>
    <?php $cs->registerScriptFile($s1.'js/jquery.fallr/jquery.fallr.js');?>
    <?php $cs->registerScriptFile($s1.'js/public.js');?>
    <?php $cs->registerCssFile($s1.'css/login.css'); ?>
    <?php $cs->registerCssFile($s1.'js/jquery.fallr/jquery.fallr.css');?>
    <?php $cs->registerScriptFile($s1. 'js/md5.js');?>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo Yii::app()->request->baseUrl.'/static/admin/img/bh.png';?>"/>
</head>
<body>
<img src="img/bg.png" alt="" class="wave">
<div class="wrapper flex-center">
    <div class="conttt">
        <div class="img">
            <img src="img/log.svg" alt="">
        </div>
    </div>
    <div class="main">
        <?php $form = $this->beginWidget('CActiveForm', get_form_login()); ?>
        <div class="item"><span class="login-title">用户注册</span></div>
        <div class="item">
            <?php echo $form->textField($model, 'name', array('maxlength' => 50, 'class' => 'user-input', 'placeholder'=>'请输入用户真实姓名')); ?>
            <?php echo $form->error($model, 'name', $htmlOptions = array()); ?>
        </div><!--item end-->
        <div class="item">
            <?php echo $form->textField($model, 'phone', array('class' => 'user-input', 'placeholder'=>'请输入电话号码')); ?>
            <?php echo $form->error($model, 'phone', $htmlOptions = array()); ?>
        </div><!--item end-->
        <div class="item">
            <?php echo $form->passwordField($model, 'password', array('class' => 'pwd-input', 'placeholder'=>'请输入密码')); ?>
            <?php echo $form->error($model, 'password', $htmlOptions = array()); ?>
        </div><!--item end-->
        <div class="item">
            <?php echo $form->passwordField($model, 'password2', array('class' => 'pwd-input', 'placeholder'=>'请再次确认密码')); ?>
            <?php echo $form->error($model, 'password2', $htmlOptions = array()); ?>
        </div>
       
        <div class="item">
            <?php echo Select2::activeDropDownList('Role', 'roleName',Chtml::listData(BaseCode::model()->getRoleToSelect('role','','roleCode'), 'roleName', 'roleName'), array('prompt'=>'请选择注册角色','style'=>'width:160px;'));?>
            <?php echo $form->error($model, 'roleName', $htmlOptions = array()); ?>
        </div><!--item end-->
        
        <div class="item"> 
            <button class="button" onclick="register();">提交注册</button><!--item end-->
        </div>
        <div class="register flex-center">
            <a href="<?php echo $this->createUrl('index/login')?>" onclick="Goback();" >返回登录</a>
        </div>
        <?php $this->endWidget(); ?>
    </div><!--main end-->
</div><!--wrapper end-->
</body>
</html> 

<script>
    function register() {
        var post_data = $("#login_form").serialize();
        var name=$("#User_name").val();
        var phone=$("#User_phone").val();
        var account=$("#User_phone").val();
        var roleName=$("#s2id_Role_roleName").children('a').children('span').text();
        var PWD1=$("#User_password").val();
        var PWD2=$("#User_password2").val();
        var s2='<?php echo $this->createUrl("User/CheckRegister");?>';
        if(name=='' || phone=='' || account=='' || roleName=='' || PWD1==''){
            alert('请输入完整信息!');
            return;
        }
        if(roleName=='请选择注册角色'){
            alert('请选择注册角色!');
            return;
        }
        if(PWD1!==PWD2){
            alert('两次密码输入不一致，请重新输入!');
            clearPWD();
            return;
        }
        // var phoneReg = new RegExp('/^(?:(?:\+|00)86)?1(?:(?:3[\d])|(?:4[5-79])|(?:5[0-35-9])|(?:6[5-7])|(?:7[0-8])|(?:8[\d])|(?:9[189]))\d{8}$/');
        var phoneReg = new RegExp('^[1][3-8][0-9]{9}$');
        if (!phoneReg.test(phone)) {
            alert("手机号码有误，请重新输入");
            clearPHONE();
            return;
        }
        var regex = new RegExp('(?=.*[0-9])(?=.*[a-zA-Z]).{8,16}');
         //if (!regex.test(PWD1)) {
         //    alert("密码中必须包含字母、数字，且长度大于8，小于16");
         //    clearPWD();
         //    return;
         //}
        $.ajax({
            type: 'get',
            url: s2,
            data: {
                USERNAME: name,
                ACCOUNT: account,
                PHONE: phone,
                PASSWORD: PWD1,
                ROLENAME: roleName,
            },
            dataType:'json',
            success: function(data) {
                s1=data.f_kcszid;
                if (s1===1){
                    alert('提交成功，请等待审核');
                    window.history.back(-1);
                }else if(s1===0){
                    alert("该用户名已经注册");
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.log(XMLHttpRequest);
            }
        });
    }
    function clearPWD(){
        $("#User_password").val('');
        $("#User_password2").val('');
    }
    window.alert=function(str) {
        var iframe = document.createElement("IFRAME");
        iframe.style.display="none";
        iframe.setAttribute("src", 'data:text/plain');
        document.documentElement.appendChild(iframe);
        window.frames[0].window.alert(str);
        iframe.parentNode.removeChild(iframe);
    }
</script>