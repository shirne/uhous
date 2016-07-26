<?php
/**
 * 后台登录页面
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @author     Allen <movoin@gmail.com>
 * @version    $Id: Login.php 2 2010-04-27 16:47:43Z allen $
 **/
?>
<?php defined('IN_EOMS') or die ('Direct Access to this location is not allowed.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo FLEA::getAppInf('appName') . ' v' . FLEA::getAppInf('appVersion'); ?></title>
<link type="text/css" rel="stylesheet" href="../themes/sysadm/css/global.css" />
<link type="text/css" rel="stylesheet" href="../themes/sysadm/css/layout.css" />
<link type="text/css" rel="stylesheet" href="../themes/sysadm/css/login.css" />

<!--[if IE]>
<link type="text/css" rel="stylesheet" href="./css/ie.css" />
<![endif]-->

</head>

<body>
<div id="login-wrap">
    <div class="login-title"><h1><?php echo FLEA::getAppInf('appName'); ?><small>授权予 <?php echo FLEA::getAppInf('customer'); ?> 使用.</small></h1></div>
    <div class="login-form">
        <form method="post" action="<?php echo _url('Admin', 'Login'); ?>">
            <p class="tline">Username: <input class="ltext" type="text" id="username" name="username" /></p>
            <p class="fline">Password: <input class="ltext" type="password" id="password" name="password" /> <img src="<?php echo $this->_url('ImageCode'); ?>" align="absmiddle" /> <input class="imgcode" type="text" id="imgcode" name="imgcode" /> <input class="lsubmit" type="submit" value="LOGIN" /></p>
        </form>
    </div>
    <div class="login-copyright">Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. All Rights Reserved.</div>
</div>
</body>
</html>

