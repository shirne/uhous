<?php
/**
 * 品牌管理模型
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Model
 * @category   Class
 * @author     Jayzone <zhongjintang@gmail.com>
 * @version    $Id$
 **/

//{{ 载入抽象模型类
FLEA::loadClass('Model_Abstract');
//}}

class Model_Brands extends Model_Abstract
{
    /**
     * 构造函数
     */
    function __construct()
    {
        parent::__construct('Table_Brands');
    }
    /**
     * 保存品牌
     *
     * @param array $row 
     * @access public
     * @return void
     */
    function saveBrand(&$row)
    {
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
        $_uploaderPic = new Helper_Upload($_config);
        $_uploaderMinPic = new Helper_Upload($_config);

        /**
         * 开始上传图片
         */
        if ($_uploaderPic->isReady('pic')) {
            $_pic = $_uploaderPic->upload('pic');
            /**
             * 获得图片路径
             */
            if ($_pic) {
                $row['pic'] = $_pic['filename'];
            }
        }
        /**
         * 开始上传图片
         */
        if ($_uploaderMinPic->isReady('minpic')) {
            $_pic = $_uploaderMinPic->upload('minpic');
            /**
             * 获得图片路径
             */
            if ($_pic) {
                $row['minpic'] = $_pic['filename'];
            }
        }
        $_uploaderMinPic = new Helper_Upload($_config);
        if ($_uploaderMinPic->isReady('logo')) {
            $_pic = $_uploaderMinPic->upload('logo');
            /**
             * 获得图片路径
             */
            if ($_pic) {
                $row['logo'] = $_pic['filename'];
            }
        }

        $row['memo'] = serialize($row['memo']);
        $row['intro'] = serialize($row['intro']);

        /**
         * 保存数据
         */
        if ($row['brand_id']) {
            $row['brand_id'] = (int)$row['brand_id'];
        }
        if (parent::save(&$row)) {
            return true;
        }

        //{{ 载入异常处理类
        FLEA::loadClass('Exception_Failed');
        //}}
        // 抛出异常
        __THROW(new Exception_Failed('保存品牌图片失败'));
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
                    'brand_id' => $tmp[0],
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
                __THROW(new Exception_Failed('无法排序所选品牌'));
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
     * 删除全部品牌
     *
     * @param array $pkvs 
     * @access public
     * @return 成功返回 true
     */
    function removeAll($pkvs)
    {
        /**
         * 获得所有美食的图片字段
         */
        $advs = $this->getAll(
            array(
                'in()' => $pkvs
            ),
            'brand_id ASC',
            'pic',
            null,
            false
        );
        /**
         * 删除图片
         */
        $this->_delPic($advs);
        /**
         * 删除美食
         */
        if (!$this->tbl->removeByPkvs($pkvs)) {
            //{{ 载入异常处理类
            FLEA::loadClass('Exception_Failed');
            //}}
            // 抛出异常
            __THROW(new Exception_Failed('无法删除所选品牌'));
            return;
        } else {
            return true;
        }
    }
    /**
     * 删除品牌图片
     * 
     * @param int $pkv
     * @access public
     * @return void
     */
    function removeBrandPic($pkv, $witch = 'pic')
    {
        /**
         * 读出图片记录
         */
        $pic = $this->getAll(
            $pkv,
            'brand_id ASC',
            $witch,
            null,
            false
        );
        /**
         * 删除图片
         */
        $this->_delPic($pic,$witch);
        /**
         * 清空信息记录的图片字段
         */
        if (!$this->tbl->updateField(array(array('brand_id', $pkv)), $witch, '')) {
            //{{ 载入异常处理类
            FLEA::loadClass('Exception_Failed');
            //}}
            // 抛出异常
            __THROW(new Exception_Failed('删除品牌图片失败'));
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
    function _delPic($rows,$witch)
    {
        /**
         * 上传目录路径
         */
        $_uploadDir = FLEA::getAppInf('uploadPath');
        if ($rows) {
            foreach ($rows as $row) {

                if ($row[$witch] && file_exists($_uploadDir . DS . $row[$witch])) {
                    /**
                     * 删除文件
                     */
                    @unlink($_uploadDir . DS . $row[$witch]);
                }
                if ($row[$witch] && file_exists($_uploadDir . DS . 'thumb_' . $row[$witch])) {
                    /**
                     * 删除文件
                     */
                    @unlink($_uploadDir . DS . 'thumb_' . $row[$witch]);
                }
            }
        }
        /**
         * 回收内存
         */
        unset($rows);
    }

}
