
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


    <!--///////////////头部分割线  -->
    <form class="login-body" name='theForm' onsubmit="return validate()">
      <div class="login_all" style="width:1230px; margin:auto;">

      <div class="login-hd"></div>
      <div class="center-wrap" id="centerWrap">
        <div class="login-center">
          <div class="bd-logo"></div>
        </div>
        <div class="message"></div>
          <div class="z-bd">
            <div class="login-panel" id="loginPanel">
            <div class="top_title" style="width:100%; height:100px; text-align: center; font-size: 40px;">
               <text style="line-height: 100px; font-size: 40px; color: rgb(153, 153, 153);">饕餮堂</text>
            </div>
            <!-- <h3 class="panel-hd cl-link-blue"></h3> -->
            <div class="controls first">
              <svg class="iconphone" width="20px" height="20px" viewBox="0 0 20 20">
                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                  <g id="2-copy-2" sketch:type="MSArtboardGroup" transform="translate(-505.000000, -357.000000)" fill="#666">
                  </g>
                </g>
              </svg>
              <input type="text" name="username" id="username" placeholder="用户名" />
            </div>
            <div class="controls two">
              <svg class="iconphone" width="20px" height="20px" viewBox="0 0 20 20">
                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                  <g id="2-copy-2" sketch:type="MSArtboardGroup" transform="translate(-505.000000, -407.000000)" fill="#666">

                  </g>
                </g>
              </svg>
              <input type="password" id="password" placeholder="密码"/>
              <input type="hidden" id="password_md5" name="password">
            </div>
            <div class="controls last">
            <input  class="btn-a" value="登录" readonly="readonly"  onclick="login();" />
              <span style="display: none" id="login_error_msg"></span>

            </div>
            <div class="controls bside" style="border: none">
              <input type="checkbox" value="1" name="remember" id="remember" />
              <label for="remember">保存登录信息</label>
              <a class="link-forget cl-link-blue" href="get_password.php?act=forget_pwd">忘记密码?</a>
              <a class="link-home cl-link-blue" href="<?php echo $this->createUrl("register");?>">立即注册</a>
            </div>
          </div>
        </div>
      </div>
      <input type="hidden" name="act" value="signin" />
      </div>
    </form>
<style>
  .login-body{
    background-color: red;
     height:100%;
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


<script src="js/md5.js"></script>
<script language="JavaScript">

  document.forms['theForm'].elements['username'].focus();
  
  /**
   * 检查表单输入的内容
   */
  function validate()
  {

    var username = document.getElementById('username');
    var password_input = document.getElementById('password');
    var password_md5 = document.getElementById('password_md5');

    password_md5.value =  hex_md5(username.value+password_input.value);

    return true;
  }
  
</script>

<script>
function login() {
      var post_data = $("#CActiveForm").serialize();
      var s1=$("#username").val();
      var PASSWORD=$("#password").val();
      if(!s1||!PASSWORD){
        alert("请填写完整信息！");
        return;
      }
      var s2='<?php echo $this->createUrl("index/checkUser");?>';
       $.ajax({
        type: 'get',
        url: s2,
        data: {TUNAME: s1,PASSWORD:PASSWORD},
        dataType:'json',
        success: function(data) {
          if (data.TUNAME==s1){
             var s22='<?php echo $this->createUrl("index/index");?>';
             window.location.href =s22;
          }else{
             alert("用户名或密码错误");
          }
       },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
        }
    });
 }
//window.alert
function aa(str)   
  { 
var iframe = document.createElement("IFRAME");
iframe.style.display="none";
iframe.setAttribute("src", 'data:text/plain');
document.documentElement.appendChild(iframe);
window.frames[0].window.alert(str);
iframe.parentNode.removeChild(iframe);

 //function       Alert(strText){
    //   var       pWin=window.showModalDialog("b.htm",str,"dialogHeight:116px;       dialogWidth:232px;       help:       No;       resizable:       no;       status:       No;       scroll:no;       dialogTop:"+(screen.height-116)/2+"px;       dialogLeft:"+(screen.width-232)/2+"px;");
   //    }
  } 
</script>

  </body>
</html>