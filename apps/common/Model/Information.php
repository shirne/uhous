<?php
/**
 * 信息管理模型
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

class Model_Information extends Model_Abstract
{
    /**
     * 构造函数
     */
    function __construct()
    {
        parent::__construct('Table_Information');
    }
    /**
     * 通过id获得一条页面信息 
     * 
     * @access public
     * @return void
     */
    function getPageById(&$pageId)
    {
        $where = array(
            array('lang', getLanguage()),
            array('info_id', $pageId)
            );

        $sortBy = "info_id ASC";

        $field = "info_id, title, content, updated, pic";

        $data = $this->getOne($where, $sortBy, $field, false);

        return $data;
    }
    /**
     * 保存信息
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
            __THROW(new Exception_Undefined('信息标题'));
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
            'maxsize' => 1024 * 1024, // 1M
            'thumb' => array(
                'prefix' => 'thumb_',
                'width' => 139,
                'height' => 72,
                'nocut' => true
            )
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
        if ($row['info_id']) {
            $row['info_id'] = (int)$row['info_id'];
        }
        if (parent::save(&$row)) {
            return true;
        }

        //{{ 载入异常处理类
        FLEA::loadClass('Exception_Failed');
        //}}
        // 抛出异常
        __THROW(new Exception_Failed('保存信息失败'));
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
                    'info_id' => $tmp[0],
                    //'sort_id' => $tmp[1]
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
                __THROW(new Exception_Failed('无法排序所选信息'));
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
     * 删除信息
     *
     * @param array $pkvs 
     * @access public
     * @return void
     */
    function removeAll($pkvs)
    {
        if (!$pkvs) {
            //{{ 载入异常处理类
            FLEA::loadClass('Exception_Unselected');
            //}}
            // 抛出异常
            __THROW(new Exception_Unselected('信息', '删除'));
            return;
        }

        $infos = $this->getAll(
            array(
                'in()' => $pkvs
            ),
            'info_id ASC',
            'pic',
            null,
            false
        );

        /**
         * 删除信息图片
         */
        $this->_delPic($infos);

        /**
         * 删除信息
         */
        if (!$this->tbl->removeByPkvs($pkvs)) {
            //{{ 载入异常处理类
            FLEA::loadClass('Exception_Failed');
            //}}
            // 抛出异常
            __THROW(new Exception_Failed('删除信息失败'));
            return;
        }
    }

    /**
     * 删除信息中的图片
     * 
     * @param mixed $pkv 
     * @access public
     * @return void
     */
    function removeInfoPic($pkv)
    {
        /**
         * 读出图片记录
         */
        $pic = $this->getAll(
            $pkv,
            'info_id ASC',
            'pic',
            null,
            false
        );
        /**
         * 删除信息图片
         */
        $this->_delPic($pic);
        /**
         * 清空信息记录的图片字段
         */
        if (!$this->tbl->updateField(array(array('info_id', $pkv)), 'pic', '')) {
            //{{ 载入异常处理类
            FLEA::loadClass('Exception_Failed');
            //}}
            // 抛出异常
            __THROW(new Exception_Failed('删除信息图片失败'));
            return;
        }
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
}

