<?php
/**
 * 栏目管理模型
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

class Model_Columns extends Model_Abstract
{
    /**
     * 构造函数
     */
    function __construct()
    {
        parent::__construct('Table_Columns');
        /**
         * 设置字段
         */
        $this->fields = 'col_id, parent_id, col_key, name, controller, action, args, lang';
    }
    /**
     * 获得栏目树
     * 
     * @access public
     * @return array
     */
    function getTree()
    {
        /**
         * 获得所有语言版本
         */
        $allLanguages = array_keys(FLEA::getAppInf('languages'));
        /**
         * 获得所有栏目数据
         */
        $allColumns = $this->getAll(null, 'sort_id ASC');
        /**
         * 准备树状数据
         */
        if ($allColumns) {
            /**
             * 将所有栏目数据按语言版本分组
             */
            $groupColumns = array_group_by($allColumns, 'lang');
            /**
             * 将分好组的栏目数据转换成树状目录
             */
            foreach ($allLanguages as $lang) {
                if ($groupColumns[$lang]) {
                    $return[$lang] = array_to_tree($groupColumns[$lang], 'col_id', 'parent_id', 'childrens');
                }
            }
            return $return;
        }
        /**
         * 返回空数据
         */
        return null;
    }
    /**
     * 获取足迹路径
     * 
     * @param mixed $colId 
     * @access public
     * @return void
     */
    function getFootPrint($colId = null, $spliter = '')
    {
        /**
         * 读出栏目信息
         */
        $column = $this->getOne((int)$colId, 'name, parent_id');
        if ($column) {
            $footPrint = $column['name'];
            if ($column['parent_id']) {
                $fp = $this->getFootPrint((int)$column['parent_id']);
                $footPrint = $fp . $spliter . $footPrint;
            }
        }
        return $footPrint;
    }
}

