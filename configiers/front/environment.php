<?php
/**
 * 前台环境配置文件
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Config
 * @category   File
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/

// 定义模板目录
$themeDir= 'themes/default';

return array (
    // 控制器相关
    'defaultController' => 'Home',
    'controllerAccessor' => 'column',
    'actionAccessor' => 'do',

    // 访问控制相关
    'RBACSessionKey' => 'SIXHORSES.FRONT.SESSIONKEY',
    'dispatcher' => 'FLEA_Dispatcher_Auth',
    'autoQueryDefaultACTFile' => true,
    'defaultControllerACTFile' => ROOT_DIR . '/configiers/front/acl.php',
    'autoSessionStart'  => true,
    'dispatcherAuthFailedCallback' => 'callbackHandle',

    // 模板目录
    'themeDir' => $themeDir,

    // 视图相关
    'viewConfig' => array(
        'template_dir' => ROOT_DIR . DS . str_replace('/', DS, $themeDir),
    )
);

