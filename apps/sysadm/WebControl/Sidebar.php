<?php
/**
 * 侧边栏控件
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    WebControl
 * @category   Function
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/

function _ctlSidebar($name, $attribs)
{
    $opts = array('config');
    $data = FLEA_WebControls::extractAttribs( $attribs, $opts );

    /**
     * 实例化管理员管理模型
     */
    $modelAdmin =& FLEA::getSingleton('Model_Admin');
    /**
     * 实例化角色访问控制器
     */
    $rbac = FLEA::getSingleton('FLEA_Rbac');
    /**
     * 获得角色信息
     */
    $user = $rbac->getUser();
    /**
     * 读出栏目信息
     */
    $columns = $modelAdmin->buildColumns($user['roles']);
    /**
     * 实例化模板引擎
     */
    $viewClass = FLEA::getAppInf('view');
    if ($viewClass != 'PHP') {
        $tpl = FLEA::getSingleton($viewClass);
    }
    /**
     * 传入数据
     */
    if (in_array('ADMIN', $user['roles'])) {
        $tpl->assign('isadmin', 'yes');
    }
    $tpl->assign('id', $name);
    $tpl->assign('columns', $columns[getLanguage()]);

    // 回收内存
    unset($modelAdmin, $columns);

    return $tpl->fetch('layouts/sidebar.tpl');
}

