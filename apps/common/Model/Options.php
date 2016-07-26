<?php
/**
 * 配置管理模型
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Model
 * @category   Class
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/

//{{ 载入抽象模型类
FLEA::loadClass('Model_Abstract');
//}}

class Model_Options extends Model_Abstract
{
    /**
     * 构造函数
     */
    function __construct()
    {
        parent::__construct('Table_Options');
    }
    /**
     * 读取配置
     * 
     * @param mixed $name 
     * @param mixed $format 
     * @access public
     * @return void
     */
    function getOption($name = null, $format = true)
    {
        $fields = 'opt_id, name, value, lang';
        /**
         * 查询当前语言版本的配置
         */
        $where[] = array('lang', getLanguage());
        /**
         * 获取单个配置项
         */
        if ($name) {
            $where[] = array('name', trim($name));
            $options = $this->getOne($where, null, $fields);
        }
        /**
         * 获取所有配置项
         */
        $options = $this->getAll($where, null, $fields);
        if ($format) {
            return $this->_formatOptions($options);
        }
        if ($options) {
            return $options;
        }
        /**
         * 返回空数组
         */
        return array();
    }
    /**
     * 设置单个配置项
     * @todo 功能待定
     *
     * @param mixed $name
     * @param mixed $value
     * @access public
     * @return void
     */
    function setOption($name, $value)
    {
    }
    /**
     * 设置多个配置项
     *
     * @param mixed $opts
     * @access public
     * @return void
     */
    function setOptions($opts)
    {
        /**
         * 更新配置
         */
        if ($options = $this->getOption()) {
            if (is_array($opts)) {
                /**
                 * 格式化数据
                 */
                foreach ($opts as $key => $opt) {
                    $_opts[$key] = array(
                        'name' => $key,
                        'value' => $opt
                    );
                }
                /**
                 * 合并数据
                 */
                foreach ($options as $key => $opt) {
                    if ($_opts[$key]['name'] == $key) {
                        $_options[] = array(
                            'opt_id' => $opt['opt_id'],
                            'name' => $key,
                            'value' => $_opts[$key]['value']
                        );
                    }
                }
            }
            /**
             * 覆盖配置
             */
            if (!$this->tbl->updateRowset($_options)) {
                //{{ 载入异常处理类
                FLEA::loadClass('Exception_Failed');
                //}}
                // 抛出异常
                __THROW(new Exception_Failed('无法保存配置'));
                return;
            }
        } else {// 新增配置
            foreach ($opts as $key => $opt) {
                $_options[] = array(
                    'name' => $key,
                    'value' => $opt,
                    'lang' => getLanguage()
                );
            }
            /**
             * 创建新配置
             */
            if (!$this->tbl->createRowset($_options)) {
                //{{ 载入异常处理类
                FLEA::loadClass('Exception_Failed');
                //}}
                // 抛出异常
                __THROW(new Exception_Failed('无法保存配置'));
                return;
            }
        }
        /**
         * 重新载入系统配置信息
         */
        return Controller_Base::loadOptions(true);
    }
    /**
     * 格式化配置集
     * 
     * @param array $opts 
     * @access public
     * @return void
     */
    function _formatOptions($opts)
    {
        foreach ($opts as $opt) {
            $return[$opt['name']] = array(
                'opt_id' => $opt['opt_id'],
                'value' => $opt['value']
            );
        }
        return $return;
    }
}

