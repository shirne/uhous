<?php
/**
 * 分类管理模型
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

class Model_Categories extends Model_Abstract
{
    /**
     * 构造函数
     */
    function __construct()
    {
        parent::__construct('Table_Categories');
    }
    /**
     * 获得分类树
     *
     * @param int $parent
     * @access public
     * @return array
     */
    function getTree($parent = 0, $fields = 'cate_id, parent_id, name', $col_key = null)
    {
        /**
         * 设置查询条件
         */
        $where = array(
            array('lang', getLanguage())
        );

        $where[] = array('col_key', isset($col_key) ? $col_key : getColKey());
        /**
         * 设置根节点分类
         */
        if ($parent > 0) {
            $where[] = array('parent_id', $parent);
        }
        /**
         * 清除所有关联
         */
        $this->tbl->clearLinks();
        /**
         * 获得数据
         */
        $rows = $this->getAll($where, 'sort_id ASC, cate_id ASC', $fields);
        /**
         * 转换成树
         */
        if ($rows) {
            return array_to_tree($rows, 'cate_id', 'parent_id', 'children');
        }
        return $rows;
    }

    /**
     * 获得顶级分类
     *
     * @param int $parent
     * @access public
     * @return array
     */
    function getTopCates($parent = 0, $fields = 'cate_id, name', $col_key = null)
    {
        /**
         * 设置查询条件
         */
        $where = array(
            array('parent_id', (int)$parent),
            array('lang', getLanguage())
        );

        $where[] = array('col_key', isset($col_key) ? $col_key : getColKey());
        /**
         * 返回数据
         */
        return $this->getAll($where, 'sort_id ASC, cate_id ASC', $fields);
    }

    /**
     * 删除全部分类
     *
     * @param array $pkvs 
     * @access public
     * @return void
     */
    function removeAll($pkvs)
    {
        /**
         * 获得所有分类的图片字段
         */
        $categories = $this->getAll(
            array(
                'in()' => $pkvs
            ),
            'sort_id ASC',
            'pic',
            null,
            false
        );
        /**
         * 删除分类图片
         */
        $this->_delPic($categories);
        /**
         * 删除分类
         */
        if (!$this->tbl->removeByPkvs($pkvs)) {
            //{{ 载入异常处理类
            FLEA::loadClass('Exception_Failed');
            //}}
            // 抛出异常
            __THROW(new Exception_Failed('无法删除所选分类'));
            return;
        }
    }

    /**
     * 保存排序结果
     *
     * @param string $seqNoList
     * @access public
     * @return void
     */
    function saveSort($seqNoList)
    {
        if ($seqNoList) {
            /**
             * 切割为记录数组
             */
            $rows = explode(',', $seqNoList);
            /**
             * 合并数据
             */
            foreach ($rows as $row) {
                /**
                 * 切割为具体排序数组
                 */
                $tmp = explode(':', $row);
                $data[] = array(
                    'cate_id' => $tmp[0],
                    'sort_id' => $tmp[1]
                );
            }
            /**
             * 更新结果
             */
            if (!$this->tbl->updateRowset($data)) {
                //{{ 载入异常处理类
                FLEA::loadClass('Exception_Failed');
                //}}
                // 抛出异常
                __THROW(new Exception_Failed('无法排序所选分类'));
                return;
            }
            return true;
        }
        /**
         * 没有提交排序内容
         */
        //{{ 载入异常处理类
        FLEA::loadClass('Exception_Failed');
        //}}
        // 抛出异常
        __THROW(new Exception_Failed('没有提交排序内容'));
        return;
    }

    /**
     * 删除图片
     * 
     * @param mixed $rows 
     * @access protected
     * @return void
     */
    function _delPic($rows)
    {
        /**
         * 上传目录路径
         */
        $_uploadDir = FLEA::getAppInf('uploadPath');
        if ($rows) {
            foreach ($rows as $row) {
                if ($row['pic'] && file_exists($_uploadDir . DS . $row['pic'])) {
                    /**
                     * 删除文件
                     */
                    @unlink($_uploadDir . DS . $row['pic']);
                }
            }
        }
        /**
         * 回收内存
         */
        unset($rows);
    }

    /**
     * 保存分类
     *
     * @param array $row 
     * @access public
     * @return void
     */
    function saveCategory(&$row)
    {
        /**
         * 未定义分类名称
         */
        if (!$row['name']) {
            //{{ 载入异常处理类
            FLEA::loadClass('Exception_Undefined');
            //}}
            // 抛出异常
            __THROW(new Exception_Undefined('分类名称'));
            return;
        }
        /**
         * 未定义语言版本
         */
        if (!$row['lang']) {
            //{{ 载入异常处理类
            FLEA::loadClass('Exception_Undefined');
            //}}
            // 抛出异常
            __THROW(new Exception_Undefined('语言版本'));
            return;
        }
        /**
         * 未定义栏目识别
         */
        if (!$row['col_key']) {
            //{{ 载入异常处理类
            FLEA::loadClass('Exception_Undefined');
            //}}
            // 抛出异常
            __THROW(new Exception_Undefined('栏目识别'));
            return;
        }
        /**
         * 无法保存数据
         */
        if (!$this->save($row)) {
            //{{ 载入异常处理类
            FLEA::loadClass('Exception_Failed');
            //}}
            // 抛出异常
            __THROW(new Exception_Failed('保存分类失败'));
            return;
        }
    }
}

