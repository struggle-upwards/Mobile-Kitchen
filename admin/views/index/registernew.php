<!doctype html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="zh-cn"><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" lang="zh-cn"><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9" lang="zh-cn"><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="zh-cn"><!--<![endif]-->
<head>
    <meta charset="utf-8">
     <title><?php echo $cp_home;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge，chrome=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
<?php $cs = Yii::app()->clientScript;?>
<?php $cs->registerCssFile(Yii::app()->request->baseUrl.'/static/admin/css/login.css');?>
<?php $cs->registerCoreScript('jquery');?>
<?php $cs->registerScriptFile(Yii::app()->request->baseUrl.'/static/admin/js/jquery.nicescroll.js');?>

<?php $cs->registerCssFile(Yii::app()->request->baseUrl.'/static/admin/js/jquery.fallr/jquery.fallr.css');?>
<?php $cs->registerScriptFile(Yii::app()->request->baseUrl.'/static/admin/js/jquery.fallr/jquery.fallr.js');?>

<?php $cs->registerScriptFile(Yii::app()->request->baseUrl.'/static/admin/js/public.js');?>
</head>
<body>
<div class="wrapper">
    <div class="main">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_login()); ?>
     <div class="item"><h1><?php echo $cp_home;?></h1></div>
      <div class="item">
     <input type="text" name="username" id="username" autocomplete="new-username" placeholder="手机号" />
        </div><!--item end-->
        <div class="item">
        <input type="password" id="password" autocomplete="off" placeholder="密码"/>
        </div><!--item end-->
      <div class="item">
       <input type="password" id="repassword" autocomplete="off" placeholder="重输入密码"/>
      </div><!--item end-->
        <div class="item">
        <button class="button "  type="submit"  onclick="login();" style=" color: #ff000" >注册</button></div><!--item end-->
    <?php $this->endWidget(); ?>
    </div><!--main end-->
</div><!--wrapper end-->
</body>
</html>

<script>

function login() {
    var s1=$("#username").val();
    var s2='<?php echo $this->createUrl("checkRegister");?>';
    var p1,p2;
    p1=$("#password").val();
    p2=$("#repassword").val();
    s3='<?php echo $tokencode;?>';
    if(p1==p2){
     $.ajax({
      type: 'get',
      url: s2,
      data: {username: s1,password:p1,repassword:p2,checkcode:s3},
      dataType:'json',
      success: function(data) {
        if (data.username==s1){
           alert("注册成功");
           var s22='<?php echo $this->createUrl("login");?>'+s1;
           window.location.href =s22;
        }else{
           alert("账号已经存在");
        }
     },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.log(XMLHttpRequest);
      }
  });
  }else{
     alert("两次输入密碼不相同");
  }
 }

function setBlnk(){

    $("#username").val('');
    $("#password").val('');
    $("#repassword").val('');
}


function bb(str)   
  { 
var iframe = document.createElement("IFRAME");
iframe.style.display="none";
iframe.setAttribute("src", 'data:text/plain');
document.documentElement.appendChild(iframe);
window.frames[0].window.alert(str);
iframe.parentNode.removeChild(iframe);
}
function       Alert(strText){
       var       pWin=window.showModalDialog("b.htm",str,"dialogHeight:116px;       dialogWidth:232px;       help:       No;       resizable:       no;       status:       No;       scroll:no;       dialogTop:"+(screen.height-116)/2+"px;       dialogLeft:"+(screen.width-232)/2+"px;");
    
  } 
 setBlnk();
console.log('100');
 //alert("两次输入密碼不相同");
</script>

