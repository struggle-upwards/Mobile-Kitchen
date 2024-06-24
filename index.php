<?php
session_start();

defined('GATEWAY') or define('GATEWAY', 'back');

date_default_timezone_set('Asia/Shanghai');

$root_path = str_replace('\\', '/', dirname(__FILE__));
$root_path = $root_path == '/' ? '' : $root_path;
defined('ROOT_PATH') or define('ROOT_PATH', $root_path);

$site_path = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$site_path = $site_path != '/' ? $site_path : '';
defined('SITE_PATH') or define('SITE_PATH', $site_path);

require_once(ROOT_PATH . '/include/functions.php');
// change the following paths if necessary
$yii = ROOT_PATH . '/framework/yii.php';
$config = ROOT_PATH . '/admin/config/main.php';

// remove the following lines when in production mode
if (isset($_GET['debug']) && $_GET['debug'] == 1) {
    defined('YII_DEBUG') or define('YII_DEBUG', true);
} else {
    defined('YII_DEBUG') or define('YII_DEBUG', false);
}
//set_session('userAdmin','');

// 禁止Yii来处理错误和异常
// defined('YII_ENABLE_ERROR_HANDLER') or define('YII_ENABLE_ERROR_HANDLER', false);
// defined('YII_ENABLE_EXCEPTION_HANDLER') or define('YII_ENABLE_EXCEPTION_HANDLER', false);

require_once($yii);
require_once(ROOT_PATH .'/admin/extensions/yiiSelect2/Select2.php');
Yii::createWebApplication($config)->run();
