<?php
error_reporting(0);
/**
 * 后台入口文件
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Core
 * @category   File
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/

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
application::factory('sysadm')->run();

