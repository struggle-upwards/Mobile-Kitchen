<?php
/**
 * sports 帮助信息接口
 * ============================================================================

 */

define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');

$get_keyword = trim($_GET['al']); // 获取关键字
header("location:https://qmdd.gf41.net/do.php?k=".$get_keyword."&v=".$_CFG['spt_version']."&l=".$_CFG['lang']."&c=".SP_CHARSET);
?>