<?php
error_reporting(0);
/**
 * wap入口文件
 */

/**
 * 入口标识
 */
define('IN_EOMS', true);
/**
 * 载入应用入口
 */
require_once '../apps/application.php';
/**
 * 运行应用
 */
application::factory('wap')->run();

