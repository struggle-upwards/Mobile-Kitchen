<?php



if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

define('ECS_ADMIN', true);

error_reporting(E_ALL);

if (__FILE__ == '')
{
    die('Fatal error code: 0');
}

/* 初始化设置 */
@ini_set('memory_limit',          '64M');
@ini_set('session.cache_expire',  180);
@ini_set('session.use_trans_sid', 0);
@ini_set('session.use_cookies',   1);
@ini_set('session.auto_start',    0);
@ini_set('display_errors',        1);

$s0=(DIRECTORY_SEPARATOR == '\\') ? '.;' : '.:';
@ini_set('include_path',$s0. ROOT_PATH);

if (file_exists('../data/config.php'))
{
    include('../data/config.php');
}
else
{
    include('../includes/config.php');
}

/* 取得当前qmddshop所在的根目录 */
if(!defined('ADMIN_PATH'))
{
    define('ADMIN_PATH','admin');
}
define('ROOT_PATH', str_replace(ADMIN_PATH . '/includes/init.php', '', str_replace('\\', '/', __FILE__)));

if (defined('DEBUG_MODE') == false)
{
    define('DEBUG_MODE', 0);
}

if (PHP_VERSION >= '5.1' && !empty($timezone))
{
    date_default_timezone_set($timezone);
}

if (isset($_SERVER['PHP_SELF']))
{
    define('PHP_SELF', $_SERVER['PHP_SELF']);
}
else
{
    define('PHP_SELF', $_SERVER['SCRIPT_NAME']);
}

require(ROOT_PATH . 'includes/inc_constant.php');
require(ROOT_PATH . 'includes/cls_ecshop.php');
require(ROOT_PATH . 'includes/cls_error.php');
require(ROOT_PATH . 'includes/lib_time.php');
require(ROOT_PATH . 'includes/lib_base.php');
require(ROOT_PATH . 'includes/lib_common.php');
require(ROOT_PATH . ADMIN_PATH . '/includes/lib_main.php');
require(ROOT_PATH . ADMIN_PATH . '/includes/cls_exchange.php');

/* 对用户传入的变量进行转义操作。*/
if (!get_magic_quotes_gpc())
{
    if (!empty($_GET))
    {
        $_GET  = addslashes_deep($_GET);
    }
    if (!empty($_POST))
    {
        $_POST = addslashes_deep($_POST);
    }

    $_COOKIE   = addslashes_deep($_COOKIE);
    $_REQUEST  = addslashes_deep($_REQUEST);
}

/* 对路径进行安全处理 */
if (strpos(PHP_SELF, '.php/') !== false)
{
    yii_header("Location:" . substr(PHP_SELF, 0, strpos(PHP_SELF, '.php/') + 4) . "\n");
    exit();
}

/* 创建 QmddSHOP 对象 */
$ecs = new ECS($db_name, $prefix);
define('DATA_DIR', $ecs->data_dir());
define('IMAGE_DIR', $ecs->image_dir());

/* 初始化数据库类 */
  require(ROOT_PATH . 'includes/cls_mysql.php');
   $db = new cls_mysql($db_host, $db_port, $db_user, $db_pass, $db_name);
   $db_host = $db_user = $db_pass = $db_name = NULL;

/* 创建错误处理对象 */
$err = new yii_error('message.htm');

/* 初始化session */
require(ROOT_PATH . 'includes/cls_session.php');
$sess = new cls_session($db, $ecs->table('sessions'), $ecs->table('sessions_data'), 'ECSCP_ID');

/* 初始化 action */
if (!isset($_REQUEST['act']))
{
    $_REQUEST['act'] = '';
}
elseif (($_REQUEST['act'] == 'login' || $_REQUEST['act'] == 'logout' || $_REQUEST['act'] == 'signin') &&
    strpos(PHP_SELF, '/privilege.php') === false)
{
    $_REQUEST['act'] = '';
}
elseif (($_REQUEST['act'] == 'forget_pwd' || $_REQUEST['act'] == 'reset_pwd' || $_REQUEST['act'] == 'get_pwd') &&
    strpos(PHP_SELF, '/get_password.php') === false)
{
    $_REQUEST['act'] = '';
}

/* 载入系统参数 */
$_CFG = load_config();

// TODO : 登录部分准备拿出去做，到时候把以下操作一起挪过去
if ($_REQUEST['act'] == 'captcha')
{
    include(ROOT_PATH . 'includes/cls_captcha.php');

    $img = new captcha('../data/captcha/',104,36);
    @ob_end_clean(); //清除之前出现的多余输入
    $img->generate_image();

    exit;
}

require(ROOT_PATH . 'languages/' .$_CFG['lang']. '/admin/common.php');
require(ROOT_PATH . 'languages/' .$_CFG['lang']. '/admin/log_action.php');

if (file_exists(ROOT_PATH . 'languages/' . $_CFG['lang'] . '/admin/' . basename(PHP_SELF)))
{
    include(ROOT_PATH . 'languages/' . $_CFG['lang'] . '/admin/' . basename(PHP_SELF));
}

if (!file_exists('../temp/caches'))
{
    @mkdir('../temp/caches', 0777);
    @chmod('../temp/caches', 0777);
}

if (!file_exists('../temp/compiled/admin'))
{
    @mkdir('../temp/compiled/admin', 0777);
    @chmod('../temp/compiled/admin', 0777);
}

clearstatcache();

/* 如果有新版本，升级 */
if (!isset($_CFG['spt_version']))
{
    $_CFG['spt_version'] = 'v2.0.5';
}

if (preg_replace('/(?:\.|\s+)[a-z]*$/i', '', $_CFG['spt_version']) != preg_replace('/(?:\.|\s+)[a-z]*$/i', '', VERSION)
        && file_exists('../upgrade/index.php'))
{
    // 转到升级文件
    yii_header("Location: ../upgrade/index.php\n");
    exit;
}

/* 创建 Smarty 对象。*/
require(ROOT_PATH . 'includes/cls_template.php');
$smarty = new cls_template;

$smarty->template_dir  = ROOT_PATH . ADMIN_PATH . '/templates';
$smarty->compile_dir   = ROOT_PATH . 'temp/compiled/admin';
if ((DEBUG_MODE & 2) == 2)
{
    $smarty->force_compile = true;
}


$smarty->assign('lang', $_LANG);
$smarty->assign('help_open', $_CFG['help_open']);
$smarty->assign('enable_order_check', 0);
if(isset($_CFG['enable_order_check']))  // 为了从旧版本顺利升级到2.5.0
{
    $smarty->assign('enable_order_check', $_CFG['enable_order_check']);
}

/* 验证通行证信息 */
if(isset($_GET['ent_id']) && isset($_GET['ent_ac']) &&  isset($_GET['ent_sign']) && isset($_GET['ent_email']))
{
    $ent_id = trim($_GET['ent_id']);
    $ent_ac = trim($_GET['ent_ac']);
    $ent_sign = trim($_GET['ent_sign']);
    $ent_email = trim($_GET['ent_email']);
    $certificate_id = trim($_CFG['certificate_id']);
    $domain_url = $ecs->url();
    $token=$_GET['token'];
    if($token==md5(md5($_CFG['token']).$domain_url.ADMIN_PATH))
    {
        require(ROOT_PATH . 'includes/cls_transport.php');
        $t = new transport('-1',5);
        $apiget = "act=ent_sign&ent_id= $ent_id & certificate_id=$certificate_id";

        $t->request('https://qmdd.gf41.net/api.php', $apiget);
        $etable='UPDATE '.$ecs->table('shop_config');
        $db->query($etable . ' SET value = "'. $ent_id .'" WHERE code = "ent_id"');
        $db->query($etable . ' SET value = "'. $ent_ac .'" WHERE code = "ent_ac"');
        $db->query($etable . ' SET value = "'. $ent_sign .'" WHERE code = "ent_sign"');
        $db->query($etable . ' SET value = "'. $ent_email .'" WHERE code = "ent_email"');
        clear_cache_files();
        yii_header("Location: ./index.php\n");
    }
}


/* 验证管理员身份 */
if ((!isset($_SESSION['admin_id']) || intval($_SESSION['admin_id']) <= 0) &&
    $_REQUEST['act'] != 'login' && $_REQUEST['act'] != 'signin' &&
    $_REQUEST['act'] != 'forget_pwd' && $_REQUEST['act'] != 'reset_pwd' && $_REQUEST['act'] != 'check_order')
{
    /* session 不存在，检查cookie */

        if (!empty($_REQUEST['is_ajax']))
        {
            make_json_error($_LANG['priv_error']);
        }
        else
        {
            yii_header("Location: privilege.php?act=login\n");
        }
        exit;
 
}


//$smarty->assign('token','');// $_CFG['token']);

if ($_REQUEST['act'] != 'login' && $_REQUEST['act'] != 'signin' &&
    $_REQUEST['act'] != 'forget_pwd' && $_REQUEST['act'] != 'reset_pwd' && $_REQUEST['act'] != 'check_order')
{
   

 
    $admin_path = preg_replace('/:\d+/', '', $ecs->url()) . ADMIN_PATH;

    if (!empty($_SERVER['HTTP_REFERER']) &&
        strpos(preg_replace('/:\d+/', '', $_SERVER['HTTP_REFERER']), $admin_path) === false)
    {
     
        if (!empty($_REQUEST['is_ajax']))
        {
            make_json_error($_LANG['priv_error']);
        }
        else
        {
            yii_header("Location: privilege.php?act=login\n");
        }

        exit;
    }
}


/* 管理员登录后可在任何页面使用 act=phpinfo 显示 phpinfo() 信息 */
if ($_REQUEST['act'] == 'phpinfo' && function_exists('phpinfo'))
{
    phpinfo();

    exit;
}

//header('Cache-control: private');
header('content-type: text/html; charset=' . SP_CHARSET);
header('Expires: Fri, 14 Mar 1980 20:53:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

if ((DEBUG_MODE & 1) == 1)
{
    error_reporting(E_ALL);
}
else
{
    error_reporting(E_ALL ^ E_NOTICE);
}
if ((DEBUG_MODE & 4) == 4)
{
    include(ROOT_PATH . 'includes/lib.debug.php');
}

/* 判断是否支持gzip模式 */
if (gzip_enabled())
{
    ob_start('ob_gzhandler');
}
else
{
    ob_start();
}

?>
