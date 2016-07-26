<?php
error_reporting(0);
/**
 * 前台入口文件
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Core
 * @category   File
 * @author     Allen <movoin@gmail.com>
 * @version    $Id: index.php 2 2010-04-27 16:47:43Z allen $
 **/
/**
 * 网站重写规则,apache下使用.htaccess,内容如下


RewriteEngine on
RewriteBase /

RewriteCond %{HTTP_HOST} ^gaincar.com [NC]
RewriteRule ^(.*)$ http://www.uhous.com/$1 [L,R=301]

RewriteCond %{HTTP_HOST} ^www.gaincar.com [NC]
RewriteRule ^(.*)$ http://www.uhous.com/$1 [L,R=301]

RewriteCond %{HTTP_HOST} ^uhous.com [NC]
RewriteRule ^(.*)$ http://www.uhous.com/$1 [L,R=301]

RewriteRule ^((?:home|products|member|check|information)(?:/.*)?) /index.php/$1 [L,NC]

RewriteRule ^sysadm/((?:admin|advertise|columns|coupons|dashboard|download|exchange|guestbook|information|member|order|page|products|settings|setup)(?:/.*)?) /sysadm/index.php/$1 [L,NC]

ErrorDocument 404 /index.php/home/error

 * nginx下在server块内加入以下规则
    location / {
		rewrite ^(/(?:home|products|member|check|information)(?:/.*)?) /index.php$1 last;
	}
	
	location /sysadm/ {
		rewrite ^/sysadm/((?:admin|advertise|columns|coupons|dashboard|download|exchange|guestbook|information|member|order|page|products|settings|setup)(?:/.*)?) /sysadm/index.php/$1 last;
	}
 *
 *
 * 入口标识
 */
define('IN_EOMS', true);

/**
 * 载入应用入口
 */
require_once './apps/application.php';

/**
 * 运行应用
 * 根据程序支持,选择wap1.0或2.0
 * 否则运行http
 */
$ismobile = ismobile();
if ($ismobile === 1) {
	application :: factory('wap')->run();
} else
	if ($ismobile === 2) {
		application :: factory('wap1')->run();
	} else {
		application :: factory('front')->run();
	}

function ismobile() {
    //不启用wap站点
    return 0;
	//已经访问过前台
	if(isset($_SESSION['www']) && $_SESSION['www']){
		return 0;
	}
	
	//访问域名正确直接返回内容
	$serv = $_SERVER['HTTP_HOST'];
	if (stripos(strtolower($serv), 'm.') !== false) {
		return 1;
	}
	if (stripos(strtolower($serv), 'wap.') !== false) {
		return 2;
	}

	$ismobile = false;
	//否则判断
	if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])) {
		$ismobile=true;
	}
	if (!$ismobile && isset ($_SERVER['HTTP_VIA'])) {
		$ismobile = stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
	}

	if (!$ismobile && isset ($_SERVER['HTTP_USER_AGENT'])) {
		$clientkeywords = array (
			'nokia',
			'sony',
			'ericsson',
			'mot',
			'samsung',
			'htc',
			'sgh',
			'lg',
			'sharp',
			'sie-',
			'philips',
			'panasonic',
			'alcatel',
			'lenovo',
			'iphone',
			'ipod',
			'blackberry',
			'meizu',
			'android',
			'netfront',
			'symbian',
			'ucweb',
			'windowsce',
			'palm',
			'operamini',
			'operamobi',
			'openwave',
			'nexusone',
			'cldc',
			'midp',
			'wap',
			'mobile'
		);
		// 从HTTP_USER_AGENT中查找手机浏览器的关键字
		if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
			$ismobile = true;
		}
	}
	$accept = $_SERVER['HTTP_ACCEPT'];
	if(!$ismobile && strpos($accept, 'text/html')===false &&
	(strpos($accept, 'application/xhtml+xml') !== false || strpos($accept, 'text/vnd.wap.wml') !== false)){
		$ismobile = true;
	}
	if ($ismobile) {
		if (strpos($accept, 'application/xhtml+xml') !== false) {
			header('Location:http://m.uhous.net');
			exit;
		}
		if (strpos($accept, 'text/vnd.wap.wml') !== false) {
			header('Location:http://wap.uhous.net');
			exit;
		}
	}

	return 0;
}
