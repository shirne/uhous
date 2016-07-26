<?php
/**
 * 应用入口类
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Core
 * @category   Class
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/
class application
{
    /**
     * 应用名称
     *
     * @var mixed
     * @access private
     */
    private $_app = null;

    /**
     * 实例化一个应用
     *
     * @param mixed $app 
     * @access private
     * @return application
     */
    private function __construct($app = null)
    {
        // 部署模式设定
        define('DEPLOY_MODE', true);

        // FLEAPHP兼容设定
        define('NO_LEGACY_FLEAPHP', true);

        // 设置当前应用
        $this->_app = $app;

        // 设定应用程序根目录
        define('ROOT_DIR', str_replace(DIRECTORY_SEPARATOR, '/', dirname(dirname(__FILE__))));

        // 载入库文件
        include_once(ROOT_DIR . '/libs/FLEA/FLEA.php');

        // 设定应用程序相对根目录
        $baseurl = detect_uri_base();
        $p = strrpos($baseurl, '/');
        $baseurl = substr($baseurl, 0, $p);
        define('ROOT_ABS_DIR', str_replace('sysadm', '', $baseurl));

        // 缓存目录位置
        FLEA::setAppInf('internalCacheDir', ROOT_DIR . '/cache/runtime');

        // 写入配置
        FLEA::setAppInf($this->loadConfig());

        // 设置搜索目录
        FLEA::import(ROOT_DIR . '/apps/' . $this->_app);
        FLEA::import(ROOT_DIR . '/apps/common');

        // 初始化环境
        FLEA::init();

        // 注册当前应用
        FLEA::register($this, 'application');
    }

    /**
     * 导入配置信息
     *
     * @access private
     * @return array
     */
    private function loadConfig()
    {
        // 模式配置文件
        $deploy = defined('DEPLOY_MODE') && DEPLOY_MODE;
        if ( $deploy ) {
            $lifetime = 86400; // 1 天
        } else {
            $lifetime = 0;
        }

        // 缓存识别
        $cacheid = 'config.' . ($this->_app ? $this->_app . '.' : '') . ($deploy ? 'deploy' : 'development');

        // 返回缓存内容
        $config = FLEA::getCache($cacheid, $lifetime, true, true);
        if ( is_array($config) ) { return $config; }

        // 设置配置文件位置
        $files = array(
            ROOT_DIR . '/configiers/environment.php',
            ROOT_DIR . '/configiers/database.php'
        );
        if ( $deploy ) {
            $files[] = ROOT_DIR . '/configiers/deploy.php';
        } else {
            $files[] = ROOT_DIR . '/configiers/devel.php';
        }
        if ($this->_app) {
            $files[] = ROOT_DIR . '/configiers/' . $this->_app . '/environment.php';
        }

        $config = array();

        // 读入配置
        foreach ($files as $filename) {
            $filename = str_replace('/', DS, $filename);
            if (!file_exists($filename)) { continue; }
            $contents = include $filename;
            $config = array_merge_recursive($config, $contents);
        }

        // 将配置文件写入缓存
        FLEA::writeCache($cacheid, $config, true);

        return $config;
    }

    /**
     * 以工厂方式创建一个应用
     *
     * @param mixed $app
     * @static
     * @access public
     * @return application
     */
    static function factory($app)
    {
       return new application($app);
    }

    /**
     * 运行应用
     *
     * @access public
     * @return void
     */
    function run()
    {
    	FLEA::setAppInf('dispatcherFailedCallback','wrong');
        FLEA::runMVC();
    }
}

/**
 * 超时操作句柄
 *
 * @access public
 * @return void
 */
function callbackHandle()
{
    js_alert('登录超时，请重新登录!', 0, url());
}

/**
 * 错误操作
 */
function wrong(){
	header('Location:/index.php/home/error');
}

