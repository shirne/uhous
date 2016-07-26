<?php
/**
 * 后台环境配置文件
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Config
 * @category   File
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/

return array (
    // 控制器相关
    'defaultController' => 'Admin',
    'controllerAccessor' => 'module',
    'actionAccessor' => 'do',

    // 访问控制相关
    'RBACSessionKey' => 'SIXHORSES.SYSADM.SESSIONKEY',
    'dispatcher' => 'FLEA_Dispatcher_Auth',
    'autoQueryDefaultACTFile' => true,
    'defaultControllerACTFile' => str_replace('/', DS, ROOT_DIR . '/configiers/sysadm/acl.php'),
    'autoSessionStart'  => true,
    'controllerACTLoadWarning' => false,
    'dispatcherAuthFailedCallback' => 'callbackHandle',

    // 定义目录
    'templatesDir' => str_replace('/', DS, ROOT_DIR . '/sysadm'),
    'fckDir' => str_replace('/', DS, ROOT_DIR . '/libs/fckeditor'),

    // 视图相关
    'viewConfig' => array(
        'template_dir' => str_replace('/', DS, ROOT_DIR . '/sysadm/templates'),
    )
);

