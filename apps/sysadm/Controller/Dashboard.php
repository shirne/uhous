<?php
/**
 * 后台控制台控制器
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Controller
 * @category   Class
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/
class Controller_Dashboard extends Controller_Base
{
    /**
     * RBAC 角色访问控制器类实例
     * 
     * @var FLEA_Rbac
     * @access private
     */
    private $rbac = null;
    /**
     * 构造函数
     */
    function __construct()
    {
        // 执行父类构造函数
        parent::__construct();
        /**
         * 实例化 Rbac 角色访问控制器类
         */
        $this->rbac =& FLEA::getSingleton('FLEA_Rbac');
    }

    /**
     * 控制台视图
     */
    function actionIndex()
    {
        /**
         * 获得管理员用户信息
         */
        $data['admin'] = $this->rbac->getUser();
        /**
         * 输出控制台主视图
         */
        $this->_executeView('layouts/main.tpl', $data);
    }

    /**
     * 欢迎页视图
     */
    function actionWelcome()
    {
        /**
         * 获得管理员用户信息
         */
        $data['admin'] = $this->rbac->getUser();
        // 设置超时时间
        $lifetime = FLEA::getAppInf('lifetime');
        // 缓存系统信息
        $cacheid = 'system.info';
        $sysinfo = FLEA::getCache($cacheid, $lifetime, true, true);
        if (!is_array($sysinfo)) {
            $sysinfo = _sysinfo();
            FLEA::writeCache($cacheid, $sysinfo, true);
        }
        $data['sys'] = $sysinfo;
        // 输出视图
        $this->_executeView('core/sysinfo.tpl', $data);
    }
    
    
}


/**
 * 获得系统信息
 * 
 * @access protected
 * @return array
 */
function _sysinfo()
{
    $os = explode(" ", php_uname()); 
    return array(
        'serverName' => $os[1],
        'serverHost' => $_SERVER['SERVER_NAME'] . ' ( ' . @gethostbyname($_SERVER['SERVER_NAME']) . ' )',
        'serverOS' => $os[0] . $os[2],
        'serverSoftwave' => $_SERVER['SERVER_SOFTWARE'],
        'serverPort' => $_SERVER['SERVER_PORT'],
        'serverTime' => date("Y年n月j日 H:i:s"),
        'phpRunType' => strtoupper(php_sapi_name()),
        'phpVersion' => PHP_VERSION,
        'phpSafeMode' => _getcon('safe_mode'),
        'phpZend' => (get_cfg_var('zend_optimizer.optimization_level') ||
                      get_cfg_var('zend_extension_manager.optimizer_ts') ||
                      get_cfg_var('zend_extension_ts')) ?
                      '<span style="color: green">YES</span>' : '<span style="color: red">NO</span>',
        'phpExecTime' => _getcon('max_execution_time'),
        'phpMaxUpload' => _getcon('upload_max_filesize')
    );
}

/**
 * 读出 PHP 配置信息
 * 
 * @param mixed $varName
 * @access protected
 * @return string
 */
function _getcon($varName)
{
    switch($res = get_cfg_var($varName))
    {
        case 0:
            return '<span style="color: red">NO</span>';
            break;
        case 1:
            return '<span style="color: green">YES</span>';
            break;
        default:
            return $res;
            break;
    }
}

