<?php
/**
 * 会员方案规则管理模型
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

class Model_Rules extends Model_Abstract
{
    /**
     * 构造函数
     */
    function __construct()
    {
        /**
         * 构造表数据入口实例
         */
        parent::__construct('Table_Rules');
    }

    /**
     * 保存方案
     *
     * @param array $row
     * @access public
     * @return void
     */
    function save(&$row)
    {
        /**
         * 未定义显示金额
         */
        if (!$row['name']) {
            //{{ 载入异常处理类
            FLEA::loadClass('Exception_Undefined');
            //}}
            // 抛出异常
            __THROW(new Exception_Undefined('显示金额'));
            return;
        }
        /**
         * 未定义数值金额
         */
        if (!$row['money']) {
            //{{ 载入异常处理类
            FLEA::loadClass('Exception_Undefined');
            //}}
            // 抛出异常
            __THROW(new Exception_Undefined('数值金额'));
            return;
        }
        /**
         * 未定义折扣
         */
        if (!$row['discount']) {
            //{{ 载入异常处理类
            FLEA::loadClass('Exception_Undefined');
            //}}
            // 抛出异常
            __THROW(new Exception_Undefined('折扣'));
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
         * 转换数据类型
         */
        $row['discount'] = (float)$row['discount'];
        $row['money'] = (int)$row['money'];
        $row['plan_id'] = (int)$row['plan_id'];
        if ($row['rule_id']) {
            $row['rule_id'] = (int)$row['rule_id'];
        }

        /**
         * 保存数据
         */
        if (parent::save(&$row)) {
            return true;
        }

        //{{ 载入异常处理类
        FLEA::loadClass('Exception_Failed');
        //}}
        // 抛出异常
        __THROW(new Exception_Failed('保存规则失败'));
        return;
    }
}

