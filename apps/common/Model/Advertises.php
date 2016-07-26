<?php
/**
 * 广告管理模块模型 
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

class Model_Advertises extends Model_Abstract
{
    /**
     * 构造函数 
     */
    function __construct()
    {
        /**
         * 构造表数据入口实例
         */
        parent::__construct('Table_Advertises');
    }
    /**
     * 保存广告
     *
     * @param array $row
     * @access public
     * @return void
     */
    function save(&$row)
    {
        /**
         * 未定义信息标题
         */
        if (!$row['title']) {
            //{{ 载入异常处理类
            FLEA::loadClass('Exception_Undefined');
            //}}
            // 抛出异常
            __THROW(new Exception_Undefined('广告标题'));
            return;
        }
        /**
         * 未定义信息标题
         */
        if (!$row['sort_id']) {
            //{{ 载入异常处理类
            FLEA::loadClass('Exception_Undefined');
            //}}
            // 抛出异常
            __THROW(new Exception_Undefined('显示顺序'));
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

        //{{ 载入文件上传助手类
        FLEA::loadClass('Helper_Upload');
        //}}

        /**
         * 上传配置
         */
        $_config = array(
            'uploadDir' => FLEA::getAppInf('uploadPath'),
            'fileType' => '.jpg/.png/.gif',
            'maxsize' => 1024 * 1024 // 1M
        );

        /**
         * 实例化文件上传助手类
         */
        $_uploader = new Helper_Upload($_config);

        /**
         * 开始上传图片
         */
        if ($_uploader->isReady('pic')) {
            $_pic = $_uploader->upload('pic');
            /**
             * 获得图片路径
             */
            if ($_pic) {
                $row['pic'] = $_pic['filename'];
            }
        }

        /**
         * 保存数据
         */
        if ($row['adv_id']) {
            $row['adv_id'] = (int)$row['adv_id'];
        }
        if (parent::save(&$row)) {
            return true;
        }

        //{{ 载入异常处理类
        FLEA::loadClass('Exception_Failed');
        //}}
        // 抛出异常
        __THROW(new Exception_Failed('保存广告失败'));
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
                    'adv_id' => $tmp[0],
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
                __THROW(new Exception_Failed('无法排序所选广告'));
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
     * 删除全部广告
     *
     * @param array $pkvs 
     * @access public
     * @return 成功返回 true
     */
    function removeAll($pkvs)
    {
        /**
         * 获得所有广告的图片字段
         */
        $advs = $this->getAll(
            array(
                'in()' => $pkvs
            ),
            'sort_id ASC',
            'pic',
            null,
            false
        );
        /**
         * 删除图片
         */
        $this->_delPic($advs);
        /**
         * 删除品牌
         */
        if (!$this->tbl->removeByPkvs($pkvs)) {
            //{{ 载入异常处理类
            FLEA::loadClass('Exception_Failed');
            //}}
            // 抛出异常
            __THROW(new Exception_Failed('无法删除所选广告'));
            return;
        } else {
            return true;
        }
    }

    /**
     * 删除广告图片
     * 
     * @param int $pkv
     * @access public
     * @return void
     */
    function removeAdvPic($pkv)
    {
        /**
         * 读出图片记录
         */
        $pic = $this->getAll(
            $pkv,
            'sort_id ASC',
            'pic',
            null,
            false
        );
        /**
         * 删除图片
         */
        $this->_delPic($pic);
        /**
         * 清空信息记录的图片字段
         */
        if (!$this->tbl->updateField(array(array('adv_id', $pkv)), 'pic', '')) {
            //{{ 载入异常处理类
            FLEA::loadClass('Exception_Failed');
            //}}
            // 抛出异常
            __THROW(new Exception_Failed('删除广告图片失败'));
            return;
        }
    }

    /**
     * 删除图片
     * 
     * @param array $rows
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
}
