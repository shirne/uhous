<?php
/**
 * 定义 Smarty 模板引擎类
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Helper
 * @category   Class
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/

// {{{ 载入Smarty类

do {
    if (PHP5) {
        if (class_exists('Smarty', false)) { break; }
    } else {
        if (class_exists('Smarty')) { break; }
    }

    $viewConfig = FLEA::getAppInf('viewConfig');
    if (!isset($viewConfig['smartyDir']) && !defined('SMARTY_DIR')) {
        FLEA::loadClass('FLEA_View_Exception_NotConfigurationSmarty');
        return __THROW(new FLEA_View_Exception_NotConfigurationSmarty());
    }

    $filename = $viewConfig['smartyDir'] . '/Smarty.class.php';
    if (!is_readable($filename)) {
        FLEA::loadClass('FLEA_View_Exception_InitSmartyFailed');
        return __THROW(new FLEA_View_Exception_InitSmartyFailed($filename));
    }

    require($filename);
} while (false);

// }}}

/**
 * Helper_Smarty 提供对Smarty模板引擎的支持
 * 
 */
class Helper_Smarty extends Smarty
{
    /**
     * 构造函数
     * 
     * @access public
     * @return Helper_Smarty
     */
    function __construct() {
        parent::Smarty();

        $viewConfig = FLEA::getAppInf('viewConfig');
        if (is_array($viewConfig)) {
            foreach ($viewConfig as $key => $value) {
                if (isset($this->{$key})) {
                    $this->{$key} = $value;
                }
            }
        }

        new Helper_SmartyFunctions($this);
    }
}

/**
 * Helper_SmartyFunctions 扩展了Smarty模板引擎，
 * 提供对 FleaPHP 内置功能的直接支持，
 * 以及对 SixHorses EOMS 系统功能的支持。
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Helper
 * @category   Class
 * @author     Allen <movoin@gmail.com>
 **/

class Helper_SmartyFunctions
{
    /**
     * 构造函数
     * 
     * @param Smarty $tpl 
     * @access public
     * @return Helper_SmartyFunctions
     */
    function __construct(& $tpl) {
        $tpl->register_function('url',          array(& $this, '_fp_func_url'));
        $tpl->register_function('webcontrol',   array(& $this, '_fp_func_webcontrol'));
        $tpl->register_function('_t',           array(& $this, '_fp_func_t'));
        $tpl->register_function('get_app_inf',  array(& $this, '_fp_func_get_app_inf'));
        $tpl->register_function('option', array(& $this, '_sh_func_option'));
        $tpl->register_function('load_css', array(& $this, '_sh_func_load_css'));
        $tpl->register_function('load_js', array(& $this, '_sh_func_load_js'));

        $tpl->register_modifier('parse_str',    array(& $this, '_sh_mod_parse_str'));
        $tpl->register_modifier('to_hashmap',   array(& $this, '_sh_mod_to_hashmap'));
        $tpl->register_modifier('col_values',   array(& $this, '_sh_mod_col_values'));
    }

    /**
     * 载入 Css 文件
     * 
     * @param mixed $params
     * @access public
     * @return string
     */
    function _sh_func_load_css($params)
    {
        $params['type'] = 'css';
        return $this->_sh_load_file($params);
    }
 
    /**
     * 载入 Js 文件
     * 
     * @param mixed $params
     * @access public
     * @return string
     */
    function _sh_func_load_js($params)
    {
        $params['type'] = 'js';
        return $this->_sh_load_file($params);
    }

    /**
     * 载入 Css/Js 文件，并尝试 Gzip 压缩输出
     * 
     * @param mixed $params 
     * @access protected
     * @return string
     */
    private function _sh_load_file($params)
    {
        if (!$params['files']) {
            return;
        }
        // 得到文件名
        $files = explode(',', $params['files']);
        // 返回结果
        return Helper_Merger($params['label'], $files, $params['version'], $params['type']);
    }

    /**
     * 获得相关配置
     * 
     * @param mixed $params 
     * @access public
     * @return string|array
     */
    function _sh_func_option($params)
    {
        $options = FLEA::getAppInf('options');

        if (!$options) { return ; }

        foreach ($options as $key => $opt) {
            $_options[$key] = $opt['value'];
        }
        if ($params['key']) {
            return $_options[$params['key']];
        }
        return $_options;
    }

    /**
     * 提供对 FleaPHP url() 函数的支持
     * 
     * @param mixed $params
     * @access public
     * @return string
     */
    function _fp_func_url($params)
    {
        $controllerName = isset($params['controller']) ? $params['controller'] : null;
        unset($params['controller']);
        $actionName = isset($params['action']) ? $params['action'] : null;
        unset($params['action']);
        $anchor = isset($params['anchor']) ? $params['anchor'] : null;
        unset($params['anchor']);

        $options = array('bootstrap' => isset($params['bootstrap']) ? $params['bootstrap'] : null);
        unset($params['bootstrap']);

        $args = array();
        foreach ($params as $key => $value) {
            if (is_array($value)) {
                $args = array_merge($args, $value);
                unset($params[$key]);
            }
        }
        $args = array_merge($args, $params);

        return _url($controllerName, $actionName, $args, $anchor, $options);
    }

    /**
     * 提供对 FleaPHP WebControls 的支持
     * 
     * @param mixed $params
     * @access public
     * @return string
     */
    function _fp_func_webcontrol($params)
    {
        $type = isset($params['type']) ? $params['type'] : 'textbox';
        unset($params['type']);
        $name = isset($params['name']) ? $params['name'] : null;
        unset($params['name']);

        $ui =& FLEA::initWebControls();
        return $ui->control($type, $name, $params, true);
    }

    /**
     * 提供对 FleaPHP _T() 函数的支持
     * 
     * @param mixed $params
     * @access public
     * @return string
     */
    function _fp_func_t($params)
    {
        return _T($params['key'], isset($params['lang']) ? $params['lang'] : null);
    }

    /**
     * 提供对 FLEA::getAppInf() 方法的支持
     * 
     * @param mixed $params
     * @access public
     * @return array|string
     */
    function _fp_func_get_app_inf($params)
    {
        return FLEA::getAppInf($params['key']);
    }

    /**
     * 将字符串分割为数组
     * 
     * @param mixed $string
     * @access public
     * @return array
     */
    function _fp_mod_parse_str($string)
    {
        $arr = array();
        parse_str(str_replace('|', '&', $string), $arr);
        return $arr;
    }

    /**
     * 将二维数组转换为 hashmap
     * 
     * @param mixed $data
     * @param mixed $f_key
     * @param string $f_value
     * @access public
     * @return array
     */
    function _fp_mod_to_hashmap($data, $f_key, $f_value = '')
    {
        $arr = array();
        if (!is_array($data)) { return $arr; }
        if ($f_value != '') {
            foreach ($data as $row) {
                $arr[$row[$f_key]] = $row[$f_value];
            }
        } else {
            foreach ($data as $row) {
                $arr[$row[$f_key]] = $row;
            }
        }
        return $arr;
    }

    /**
     * 获取二维数组中指定列的数据
     * 
     * @param mixed $data
     * @param mixed $f_value
     * @access public
     * @return array
     */
    function _fp_mod_col_values($data, $f_value)
    {
        $arr = array();
        if (!is_array($data)) { return $arr; }
        foreach ($data as $row) {
            $arr[] = $row[$f_value];
        }
        return $arr;
    }
}

