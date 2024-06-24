
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title><?php echo $cp_home;?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link href="styles/general.css" rel="stylesheet" type="text/css" />
    <link href="styles/main.css" rel="stylesheet" type="text/css" />
    <link href="styles/unit_enter.css" rel="stylesheet" type="text/css">
    <style type="text/css">
      body,html {
        height: 100%;
        overflow: hidden;
      }
    </style>
    <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="js/jquery.json.js"></script>
    <script type="text/javascript" src="js/global.js"></script>
    <script type="text/javascript" src="js/utils.js"></script>
    <script type="text/javascript" src="js/transport_jquery.js"></script>
    <script language="JavaScript">
      // 这里把JS用到的所有语言都赋值到这里
      var process_request = "正在处理您的请求...";
      var todolist_caption = "记事本";
      var todolist_autosave = "自动保存";
      var todolist_save = "保存";
      var todolist_clear = "清除";
      var todolist_confirm_save = "是否将更改保存到记事本？";
      var todolist_confirm_clear = "是否清空内容？";
      var user_name_empty = "管理员用户名不能为空!";
      var password_invaild = "密码必须同时包含字母及数字且长度不能小于6!";
      var email_empty = "Email地址不能为空!";
      var email_error = "Email地址格式不正确!";
      var password_error = "两次输入的密码不一致!";
      var captcha_empty = "您没有输入验证码!";
      if (window.parent != window) {
          window.top.location.href = location.href;
      } 
    </script>
  </head>
  <body style="height: 100%;padding: 0">


    <!--///////////////头部分割线  -->
    <form class="login-body" name='theForm' onsubmit="return validate()">

      <div class="center-wrap" id="centerWrap">
        <div class="login-center">
          <div class="bd-logo"></div>
        </div>
        <div class="message"></div>
          <div class="z-bd">
            <div class="login-panel" id="loginPanel">
            <h3 class="panel-hd cl-link-blue">新用户注册</h3>
            <div class="controls first">
              <input type="text" name="username" id="phone" placeholder="手机号" />
            </div>
          <div class="controls first">
            <input type="password" id="password" autocomplete="off" placeholder="密码"/>
          </div><!--item end-->
      <div class="controls first">
       <input type="password" id="repassword" autocomplete="off" placeholder="重输入密码"/>
      </div><!--item end-->

      
    <div class="controls last" onclick="register();">
     <!-- <button class="button" onclick="register();">提交注册</button> -->
    <input class="btn-a" value="提交注册" readonly="readonly"/>
      <span style="display: none" id="login_error_msg"></span>

    </div>
 
  </div>
        </div>
      </div>
      <input type="hidden" id="password_md5" value="" />
      <input type="hidden" name="act" value="signin" />
      </div>
    </form>
<style>
  .login-body{
    background-color: red;
     height:75%;
  }
  #bottomContainer{
    background-color: #181a1a;
    width: 100%;
    height: 25%;
    position: fixed;
    bottom: 0;
  }
  #bottomInnerContainer1{
     width: 93%;
     margin: auto;
     margin-top: 10px;
     border-top: 1px dotted #ccc;
     border-bottom: 1px dotted #ccc;
     height: 180px;
     display: flex;
     align-items: center;
     justify-content: center;
     gap: 20px;
  }
  #bottomInnerContainer2{
     width: 93%;
     margin: auto;
     margin-top: 10px;
     display: flex;
     align-items: center;
     justify-content: space-between;
     color:#9ca2a2;
  }
  #rightContinaer{
    display: flex;
    gap: 15px;
  }
  .rightItem{
      color: white;
      text-align:center;
  }
  .rightItem img{
     width: 70px;
     height: 70px;
  }
  .minInfo{
    color:#9ca2a2;
  }
  #midContainer{
    display: flex;
    gap: 5px;
    flex-direction: column;
  }
  #leftContainer{
    gap:5px;
    display: flex;
    flex-direction: column;
    color: white;
  }
</style>

<div id="bottomContainer">
<text style="color: red;">还没开放注册还没开放注册还没开放注册，暑假再完善了，，，，，<text>
</div>
<script src="js/md5.js"></script>
<script language="JavaScript">

  document.forms['theForm'].elements['phone'].focus();
  
  /**
   * 检查表单输入的内容
   */
  function validate() {
    var phone = document.getElementById('phone');
    var password_input = document.getElementById('password');
    var password_md5 = document.getElementById('password_md5');
    password_md5.value =  hex_md5(phone.value+password_input.value);
    return true;
  }
  
</script>

<script>

function register() {
        var post_data = $("#login_form").serialize();
        var phone=$("#phone").val();
        var password=$("#password").val();
        var repassword=$("#repassword").val();
        var s2='<?php echo $this->createUrl("clubadmin/CreateAdmin");?>';
        if(phone==''   || password=='' || repassword==''){
            alert('请输入完整信息!');
            return;
        }
        console.log('3');
        if(password!==repassword){
            alert('两次密码输入不一致!');
            return;
        }
        // var phoneReg = new RegExp('/^(?:(?:\+|00)86)?1(?:(?:3[\d])|(?:4[5-79])|(?:5[0-35-9])|(?:6[5-7])|(?:7[0-8])|(?:8[\d])|(?:9[189]))\d{8}$/');
        var phoneReg = new RegExp('^[1][3-8][0-9]{9}$');
        if (!phoneReg.test(phone)) {
            alert("手机号码有误，请重新输入");
           return;
        }
        //var regex = new RegExp('(?=.*[0-9])(?=.*[a-zA-Z]).{8,16}');
        $.ajax({
            type: 'get',
            url: s2,
            data: {
                //USERNAME: name,
                //ACCOUNT: account,
                phone: phone,
                password: password,
                //ROLENAME: roleName,
            },
            dataType:'json',
            success: function(data) {
                console.log('data=',data);
                s1=data.status;
                if (s1==1){
                    alert('注册成功');
                    var s22='<?php echo $this->createUrl("index/index");?>';
                    window.location.href =s22;
                }else if(s1==0){
                    alert(data.msg);
                }else alert('注册失败，请检查网络设置');
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                //console.log(XMLHttpRequest);
            }
        });
    }

    // window.alert=function(str) {
    //     var iframe = document.createElement("IFRAME");
    //     iframe.style.display="none";
    //     iframe.setAttribute("src", 'data:text/plain');
    //     document.documentElement.appendChild(iframe);
    //     window.frames[0].window.alert(str);
    //     iframe.parentNode.removeChild(iframe);
    // }
</script>
</script>

  </body>
</html>