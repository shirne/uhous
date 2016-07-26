<?php
/**
 * 页面公共头部
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @author     Allen <movoin@gmail.com>
 * @version    $Id: Header.inc.php 2 2010-04-27 16:47:43Z allen $
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
<link type="text/css" rel="stylesheet" href="../themes/sysadm/css/ui.css" />
<link type="text/css" rel="stylesheet" href="../themes/sysadm/css/pagenav.css" />
<link type="text/css" rel="stylesheet" href="../themes/sysadm/css/effects.css" />
<link type="text/css" rel="stylesheet" href="../themes/sysadm/css/jquery.treeview.css" />

<script type="text/javascript" src="../themes/sysadm/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../themes/sysadm/js/jquery-ui-1.8.min.js"></script>
<script type="text/javascript" src="../themes/sysadm/js/jquery.layout.min-1.2.0.js"></script>
<script type="text/javascript" src="../themes/sysadm/js/jquery.treeview.min.js"></script>
<script type="text/javascript" src="../themes/sysadm/js/jquery.purr.js"></script>
<script type="text/javascript" src="../themes/sysadm/js/layout.js"></script>

<!--[if IE]>
<link type="text/css" rel="stylesheet" href="../themes/sysadm/css/ie.css" />
<![endif]-->

<!--[if IE 6]>
<script type="text/javascript" src="../themes/sysadm/js/DD_belatedPNG.js"></script>
<script type="text/javascript">
    DD_belatedPNG.fix('.pngicon, img');
</script>
<![endif]-->

</head>

<body>

