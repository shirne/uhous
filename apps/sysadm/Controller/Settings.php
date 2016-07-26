<?php
/**
 * 网站设置控制器
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Controller
 * @category   Class
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/
class Controller_Settings extends Controller_Base
{
    /**
     * 系统配置模型实例
     *
     * @var Model_Options
     * @access private
     */
    private $modelOptions = null;

    /**
     * 构造函数
     */
    function __construct()
    {
        // 执行父类构造函数
        parent::__construct();
        /**
         * 实例化系统配置模型
         */
        $this->modelOptions = FLEA::getSingleton('Model_Options');
    }

    /**
     * 网站设置视图
     */
    function actionIndex()
    {
        /**
         * Smarty中无法在函数中使用函数返回值
         */
        $data['copyright'] = getOption('copyright');
        /**
         * 设置返回视图
         */
        $this->_setBack();
        // 输出网站设置视图
        $this->_executeView('core/settings.tpl', $data);
    }

    /**
     * 保存网站设置
     */
    function actionSave()
    {
        /**
         * 设置异常拦截点
         */
        __TRY();

        /**
         * 保存配置
         */
        $this->modelOptions->setOptions($_POST);
        /**
         * 获取抛出的异常
         */
        $ex = __CATCH();
        /**
         * 判断是否是一个异常
         */
        if (__IS_EXCEPTION($ex)) {
            js_alert($ex->getMessage(), 0, $this->_getBack());
        }
        /**
         * 返回上一页面
         */
        $this->_goBack();
    }

    /**
     * 清空缓存视图
     */
    function actionClearCache()
    {
        if ($type = $_POST['type']) {
            /**
             * 载入清空缓存助手
             */
            FLEA::loadFile('Helper_ClearCache');
            $clear_ob = array(
                'runtime' => '开始清空数据缓存'
            );
            /**
             * 设置要清空的缓存目录
             */
            if ($type == 'runtime') {
                $dir = FLEA::getAppInf('internalCacheDir');
            } elseif ($type == 'tmp') {
                $viewConfig = FLEA::getAppInf('viewConfig');
                $dir = $viewConfig['compile_dir'];
            }
            Helper_ClearCache($clear_ob[$type], $dir);
        } else {
            // 输出清空缓存视图
            $this->_executeView('core/settings-clearcache.tpl');
        }
    }

    function actionAlipay()
    {
        $dir = ROOT_DIR . '/' . 'config/';
        $file = $dir . 'alipay_config.txt';
        if (is_file($file)) {
            $handle = fopen($dir . 'alipay_config.txt', 'a+');
            $tmp = fread($handle, filesize($file));
            $data = (array)json_decode($tmp);
            fclose($handle);
        }
        $this->_setBack();

        $this->_executeView('core/settings-alipay.tpl', $data);
    }

    function actionSaveAlipay()
    {
        if ($_POST) {

            $string = json_encode($_POST);

            $dir = ROOT_DIR . '/' . 'config/';

            $file = $dir . 'alipay_config.txt';
            unlink($file);

            $handle = fopen($dir . 'alipay_config.txt', 'a+');
            $tmp = fwrite($handle, $string);
            fclose($handle);

            $this->_goBack();
        }
    }
}

