<?php
/**
 * 设置管理模块模型 
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Model
 * @category   Class
 * @author     Jazyone <zhongjintang@gmail.com>
 * @version    $Id$
 **/

//{{ 载入模型抽象基类
FLEA::loadClass('Model_Abstract');
//}}

class Model_Setup extends Model_Abstract
{
    /**
     * 构造函数 
     */
    function __construct()
    {
        /**
         * 构造表数据入口实例
         */
        parent::__construct('Table_Setup');
    }
    /**
     * 保存设置
     *
     * @param array $row
     * @access public
     * @return void
     */
    function save(&$row)
    {
        /**
         * 未定义名称
         */
        if (!$row['name']) {
            //{{ 载入异常处理类
            FLEA::loadClass('Exception_Undefined');
            //}}
            // 抛出异常
            __THROW(new Exception_Undefined('名称'));
            return;
        }
        /**
         * 未定义介绍
         */
        if (!$row['memo']) {
            //{{ 载入异常处理类
            FLEA::loadClass('Exception_Undefined');
            //}}
            // 抛出异常
            __THROW(new Exception_Undefined('简介'));
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

        $row['params'] = serialize($row['params']);

        /**
         * 保存数据
         */
        if ($row['set_id']) {
            $row['set_id'] = (int)$row['set_id'];
        }
        if (parent::save(&$row)) {
            return true;
        }

        //{{ 载入异常处理类
        FLEA::loadClass('Exception_Failed');
        //}}
        // 抛出异常
        __THROW(new Exception_Failed('保存设置失败'));
        return;
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
                    'set_id' => $tmp[0],
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
                __THROW(new Exception_Failed('无法排序所选设置'));
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
     * 删除全部设置
     *
     * @param array $pkvs 
     * @access public
     * @return 成功返回 true
     */
    function removeAll($pkvs)
    {
        /**
         * 删除设置
         */
        if (!$this->tbl->removeByPkvs($pkvs)) {
            //{{ 载入异常处理类
            FLEA::loadClass('Exception_Failed');
            //}}
            // 抛出异常
            __THROW(new Exception_Failed('无法删除所选设置'));
            return;
        } else {
            return true;
        }
    }
}
