<?php
//header('Access-Control-Allow-Origin: http://www.baidu.com'); //设置http://www.baidu.com允许跨域访问
//header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With'); //设置允许的跨域header
date_default_timezone_set("Asia/Chongqing");
error_reporting(E_ERROR);
header("Content-Type: text/html; charset=utf-8");
$fgstr=file_get_contents("config.json");
$s1=$_SERVER['HTTP_HOST'];
$pos=strpos($string,$find,0);
$pos= ($pos === false) ? -1 : $pos;
if($pos<0){
  $fgstr=str_replace('127.0.0.1',$s1,$fgstr);
}
$CONFIG=json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "",$fgstr), true);

$site_path = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$up_path=substr($site_path,0,-27).'uploads/temp/';
$action = $_GET['action'];
switch ($action) {
    case 'config':
        $result =  json_encode($CONFIG);
        break;

    /* 上传图片 */
    case 'uploadimage':
    /* 上传涂鸦 */
    case 'uploadscrawl':
    /* 上传视频 */
    case 'uploadvideo':
    /* 上传文件 */
    case 'uploadfile':
        $result = include("action_upload.php");
        break;

    /* 列出图片 */
    case 'listimage':
        $result = include("action_list.php");
        break;
    /* 列出文件 */
    case 'listfile':
        $result = include("action_list.php");
        break;

    /* 抓取远程文件 */
    case 'catchimage':
        $result = include("action_crawler.php");
        break;

    default:
        $result = json_encode(array(
            'state'=> '请求地址出错'
        ));
        break;
}

/* 输出结果 */
if (isset($_GET["callback"])) {
    if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
        echo htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
    } else {
        echo json_encode(array(
            'state'=> 'callback参数不合法'
        ));
    }
} else {
    echo $result;
}