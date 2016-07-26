<?php
/**
 * Gzip 压缩输出 Css/Js 文件
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Core
 * @category   File
 * @author     Allen <movoin@gmail.com>
 * @version    $Id: gzip.php 2 2010-04-27 16:47:43Z allen $
 **/
error_reporting(0);

if(extension_loaded('zlib')){ //检查服务器是否开启了zlib扩展
    ob_start('ob_gzhandler');
}

// 获得参数
$file = $_GET['mf'];
$type = $_GET['mt'];
$charset = $_GET['ms'];
$nocache = (int)$_GET['mc'];

// 判断类型
if ($type == 'js') {
    $typeName = 'javascript';
} else {
    $typeName = 'css';
}

// 设置字符编码
if (!$charset) {
    $charset = 'utf-8';
}

header("content-type: text/{$typeName}; charset: {$charset}");

// 设置缓存过期时间
if ($nocache == 0) {
    header("cache-control: must-revalidate");
    $offset = 60 * 60 * 24 * 365 * 10;// css文件的距离现在的过期时间，这里设置为10年
    $expire = "expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";
    header($expire);
}

// 载入文档
include(dirname(__FILE__) . $file);

if(extension_loaded('zlib')){
  ob_end_flush(); //输出buffer中的内容
}

