<?php
/**
 * 公共助手
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Helper
 * @category   Function
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/

/**
 * 用于检索公共助手是否已加载
 */
function Helper_Common() {}

/**
 * 获取当前语言版本
 *
 * @access public
 * @return string
 */
function getLanguage($type = 'key')
{
    /**
     * 返回语言版本键值
     */
    if ($type == 'key') {
        return $_GET['lang'] ? trim($_GET['lang']) : FLEA::getAppInf('defaultLanguage');
    }
    /**
     * 读出系统支持的语言版本
     */
    $languages = FLEA::getAppInf('languages');
    /**
     * 返回语言版本名称
     */
    return $languages[getLanguage()];
}

/**
 * 获得栏目别名
 *
 * @access public
 * @return string
 */
function getColkey()
{
    return isset($_GET['colkey']) ? trim($_GET['colkey']) : trim($_POST['colkey']);
}

/**
 * 获取WebControl组件
 *
 * @param string $type
 * @param string $name
 * @param mixed $args
 * @param mixed $return
 * @return WebControl
 */
function getControl($type, $name, $args = null, $return = false)
{
    /*
     * 以单例方式实例化一个WebControls组件
     */
    $ui = FLEA::getSingleton('FLEA_WebControls');
    /*
     * 返回一个UI组件
     */
    return $ui->control($type, $name, $args, $return);
}

/**
 * URL构造器，重构自 url()
 * 使其可以满足我自定义URL的需求，更符合项目要求
 *
 * @param mixed $ctl 
 * @param mixed $act 
 * @param mixed $args 
 * @param mixed $anchor 
 * @param mixed $options 
 * @access public
 * @return string
 */
function _url($ctl = null, $act = null, $args = null, $anchor = null, $options = null)
{
    $_colKey = $_GET['colkey'] ? $_GET['colkey'] : null;
    $_langKey = getLanguage();

    if (!$args['colkey']) {
        $args['colkey'] = $_colKey;
    }
    if ($_langKey) {
        $args['lang'] = $_langKey;
    }
    return url($ctl, $act, $args, $anchor, $options);
}

/**
 * 获取系统设置项
 *
 * @param mixed $name 
 * @param mixed $format
 * @access public
 * @return array|string
 */
function getOption($name = null, $format = true)
{
    $options = FLEA::getAppInf('options');

    if (!$options) { return ; }

    if ($format) {
        foreach ($options as $key => $opt) {
            $_options[$key] = $opt['value'];
        }
    }
    if ($name) {
        return $_options[$name];
    }
    return $_options;
}

/**
 * 返回当前控制器
 *
 * @access public
 * @return string
 */
function currentController()
{
    return $_GET[FLEA::getAppInf('controllerAccessor')];
}

