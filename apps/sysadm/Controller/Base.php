<?php
/**
 * 后台控制器基类
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Controller
 * @category   Class
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/
class Controller_Base extends FLEA_Controller_Action
{
    /**
     * 构造函数
     * 
     * @access public
     */
    function __construct() {
        // 加载系统配置信息
        $this->loadOptions();
		
		/**
		 * 2012 03 08修改
		 * 启用pathinfo模式后登陆问题
		 */
		$controller=strtolower($_GET[FLEA::getAppInf('controllerAccessor')]);
		$action=strtolower($_GET[FLEA::getAppInf('actionAccessor')]);
        if ( $controller!=='admin' || !in_array($action, array('','index','login', 'index','imgcode','backrun')) ) {
            /**
             * 检测用户角色状态，角色状态消失则跳转
             */
            $modelAdmin =& FLEA::getSingleton('Model_Admin');
            $modelAdmin->checkout('Admin');
            unset($modelAdmin);
        }
    }

    /**
     * 载入系统配置信息
     *
     * @param boolean $reload
     * @access public
     */
    public function loadOptions($reload = false)
    {
        // 设置超时时间
        $lifetime = FLEA::getAppInf('lifetime');
        if ($reload) {
            $lifetime = 0;
        }
        // 缓存配置信息
        $cacheid = 'options.system';
        $options = FLEA::getCache($cacheid, $lifetime, true, true);
        if (!is_array($options)) {
            $modelOptions = FLEA::getSingleton('Model_Options');
            $options = $modelOptions->getOption();
            FLEA::writeCache($cacheid, $options, true);
            unset($modelOptions);
        }
        FLEA::setAppInf('options', $options);
    }

    /**
     * 根据数据表的元数据返回一个数组，这个数组包含所有需要初始化的数据，可以用于界面显示
     * 
     * @param & $&meta
     * @access protected
     * @return array
     */
    protected function _prepareData(& $meta) {
        $data = array();
        foreach ($meta as $m) {
            if (isset($_POST[$m ['name']])) {
                $data[$m['name']] = $_POST[$m['name']];
            } else {
                if (isset($m['defaultValue'])) {
                    $data[$m['name']] = $m['defaultValue'];
                } else {
                    $data[$m['name']] = null;
                }
            }
        }
        return $data;
    }

    /**
     * 返回用 _setBack() 设置的 URL
     * 
     * @access protected
     */
    protected function _goBack() {
        $url = $this->_getBack();
        unset($_SESSION['BACKURL']);
        redirect ($url);
    }

    /**
     * 设置返回点 URL，稍后可以用 _goBack() 返回
     * 
     * @access protected
     */
    protected function _setBack() {
        
        //URL改为PATHINFO模式,修改于2012/03/09
        //$_SESSION['BACKURL'] = $_SERVER['QUERY_STRING'];
        $_SESSION['BACKURL'] = $_SERVER['PATH_INFO'];
        
    }

    /**
     * 获取返回点 URL
     * 
     * @access protected
     * @return string
     */
    protected function _getBack() {
        if (isset($_SESSION['BACKURL'])) {
            $url = $this->rawurl($_SESSION['BACKURL']);
        } else {
            $url = $this->_url();
        }
        return $url;
    }

    /**
     * 直接提供查询字符串，生成 URL 地址
     * 
     * @param mixed $queryString 
     * @access protected
     * @return string
     */
    protected function rawurl($pathinfo) {
        //if (substr($queryString, 0, 1) == '?') {
        //   $queryString = substr($queryString, 1);
        //}
        return $_SERVER['SCRIPT_NAME'] . $pathinfo;
    }

    /**
     * 调用视图
     * 
     * @param mixed $tplname
     * @param mixed $viewdata
     * @access public
     */
    function _executeView($tplname, $viewdata = null)
    {
        /**
         * 设置系统变量
         */
        $viewdata['language'] = getLanguage();
        /**
         * 输出模板视图
         */
        parent::_executeView($tplname, $viewdata);
    }
}

