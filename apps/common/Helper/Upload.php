<?php
/**
 * 文件上传助手类
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Helper
 * @category   Class
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/

/**
 * 文件上传助手类
 *
 * @配置信息
 * $config = array(
 *      'uploadDir' => '/',
 *      'filetype' => '.jpg,.png',
 *      'maxsize' => 1048576,
 *      'filename' => '',
 *      'width' => 120,
 *      'height' => 120,
 *      'nocut' => true,
 *      'thumb' => array(
 *          'prefix' => 'thumb_',
 *          'width' => 120,
 *          'height' => 120,
 *          'nocut' => true
 *      )
 * );
 **/
class Helper_Upload
{
    /**
     * 存储设置信息
     * 
     * @var array
     * @access protected
     */
    var $_config = null;
    /**
     * 上传对象句柄
     * 
     * @var mixed
     * @access protected
     */
    var $_uploader = null;
    /**
     * 构造方法
     * 
     * @param array $config
     * @access protected
     * @return void
     */
    function Helper_Upload($config = null)
    {
        /**
         * 导入用户设置 
         */
        $this->_config = $config;
        /**
         * 实例化上传助手 
         */
        $this->_uploader = FLEA::getSingleton('FLEA_Helper_FileUploader');
    }
    /**
     * 检查上传文件是否存在
     * 
     * @param string $file 
     * @access public
     * @return void
     */
    function isReady($file)
    {
        return $this->_uploader->isFileExist($file);
    }
    /**
     * 上传方法
     * 
     * @param string $file
     * @access public
     * @return void
     */
    function upload($file)
    {
        try {
            /**
             * 开始上传 
             */
            if ($this->isReady($file)) {
                /**
                 * 获得文件操作句柄
                 */
                $upload = $this->_uploader->getFile($file);
                /**
                 * 检查上传文件类型及大小 
                 */
                $this->checkFile($upload);
                /**
                 * 获得指定的文件名，不存在则生成随机文件名。
                 */
                $fileName = isset($this->_config['filename']) ?
                    $this->_config['filename'] :
                    uniqid(isset($this->_config['prefix']) ? $this->_config['prefix'] : getColkey() . '_');
                /**
                 * 将文件名写入配置中 
                 */
                $this->_config['filename'] = $fileName;
                /**
                 * 得到带文件后缀名的文件名
                 */
                $fileName .= '.' . $upload->getExt();
                $info['filename'] = $fileName;
                /**
                 * 生成原图缩略图
                 */
                if ($this->_config['thumb'] && 
                    $this->_config['thumb']['width'] && 
                    $this->_config['thumb']['height']) {
                        $info['thumb'] = $this->reSizeImage(
                            $upload,
                            $this->_config['thumb']['width'],
                            $this->_config['thumb']['height'],
                            $this->_config['thumb']['nocut']
                        );
                }
                /**
                 * 缩小原图尺寸
                 */
                if ($this->_config['width'] && $this->_config['height']) {
                    $info = $this->reSizeImage(
                        $upload,
                        $this->_config['width'],
                        $this->_config['height'],
                        $this->_config['nocut']
                    );
                } else {
                    /**
                     * 如果不缩小原图尺寸，则直接移动图片至上传目录。 
                     */
                    $upload->move($this->_config['uploadDir'] . DS . $fileName);
                    /**
                     * 获取文件信息 
                     */
                    $info = array_merge($this->getFileInfo($upload), $info);
                }
                /**
                 * 返回上传文件信息 
                 */
                return $info;
            }
        } catch (Exception $e) {
            /**
             * 输出错误信息 
             */
            $this->error($e->getMessage());
        }
    }
    /**
     * 改变图像尺寸
     * 
     * @param mixed $file 
     * @param mixed $width 
     * @param mixed $height 
     * @access private
     * @return void
     */
    function reSizeImage($file, $width, $height, $nocut)
    {
        //{{ 载入图像处理助手类
        FLEA::loadHelper('image');
        //}}
        /**
         * 获得图像操作句柄
         */
        $image =& FLEA_Helper_Image::createFromFile($file->getTmpName(), $file->getExt());
        /**
         * 开始裁剪图片 
         */
        if ($nocut) {
            $image->crop($width, $height, true, true);
        } else {
            $image->crop($width, $height, true);
        }
        /**
         * 获得文件名
         */
        $filename = $this->_config['thumb']['prefix'] ?
            $this->_config['thumb']['prefix'] . $this->_config['filename'] :
            $this->_config['filename'];
        $filename .= '.' . $file->getExt();
        /**
         * 保存文件 
         */
        $image->saveAsJpeg($this->_config['uploadDir'] . DS . $filename);
        /**
         * 删除原图
         */
        $image->destory();
        //unset($image);
        /**
         * 返回保存信息
         */
        $info = $this->getFileInfo($file);
        $info['filename'] = $filename;
        return $info;
    }
    /**
     * 获取文件信息
     * 
     * @param mixed $file 
     * @access private
     * @return void
     */
    function getFileInfo($file)
    {
        return array(
            'oriname' => $file->getFilename(),
            'ext' => $file->getExt(),
            'size' => $file->getSize(),
            'type' => $file->getMimeType()
            );
    }
    /**
     * 检查文件大小及类型
     * 
     * @param mixed $file 
     * @access private
     * @return void
     */
    function checkFile($file)
    {
        /**
         * 设置检查项 
         */
        $allowExt = $this->_config['filetype'] ? $this->_config['filetype'] : null;
        $maxSize = $this->_config['maxsize'] ? $this->_config['maxsize'] : null;
        /**
         * 开始检查 
         */
        if (!$file->check($allowExt, $maxSize)) {
            throw new Exception('错误信息：文件类型不符合规格，或者是超过了最大上传大小。');
        }
    }
    /**
     * 输出错误信息 
     * 
     * @param mixed $e 
     * @access private
     * @return void
     */
    function error($e)
    {
        js_alert($e, 'history.back(-1)');
    }
}

