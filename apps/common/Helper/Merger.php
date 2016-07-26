<?php
/**
 * Css/Js文件合并助手
 * 负责将几个文件合并写入一个文件中
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Helper
 * @category   Function
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/

/**
 * Helper_Merger 提供 Css/Js 文件的合并操作
 * 
 * @param string $output
 * @param string $file
 * @param mixed $ver
 * @param string $type
 * @access public
 * @return string
 */
function Helper_Merger($output = '', $files = '', $ver = null, $type = 'js')
{
    // 设置合并文件输出位置
    $output_dir = str_replace('/', DS, ROOT_DIR . '/cache/data/');
    $abs_output_dir = ROOT_ABS_DIR . 'cache/data/';

    // 保存文件名称
    $saveName = $output . ($ver ? '-' . $ver : '');

    // 关闭缓存
    $nocache = 1;

    // 根据模式决定是否启用缓存
    $deploy = defined('DEPLOY_MODE') && DEPLOY_MODE;
    if ($deploy) {
        // 确定该版本文件是否存在
        if (file_exists($output_dir . $saveName . '.' . $type)) {
            //输出脚本
            _makeScript($type, $abs_output_dir . $saveName, $nocache);
            return false;
        }
        // 开启缓存
        $nocache = 0;
    }

    // 文件路径
    $baseDir = str_replace('/', DS, FLEA::getAppInf('templatesDir') . '/' . $type);

    // 合并文件
    $content = '';
    foreach ($files as $file) {
        $fileName = $baseDir . DS . trim($file) . '.' . $type;
        if (file_exists($fileName)) {
            $content .= file_get_contents($fileName) . "\n";
        }
    }

    // 写入文件
    $fp = fopen($output_dir . DS . $saveName . '.' . $type, 'w+');
    fwrite($fp, $content);
    fclose($fp);

    // 回收内存
    unset($fp, $content);

    // 输出脚本
    _makeScript($type, $abs_output_dir . $saveName, $nocache);
}

/**
 * _makeScript 负责生成 script 代码
 * 
 * @param mixed $type
 * @param mixed $fileName
 * @param int $nocache
 * @access protected
 * @return string
 */
function _makeScript($type, $fileName, $nocache)
{
    $href = ROOT_ABS_DIR . 'gzip.php?mf=' . $fileName . '.' . $type . '&mt=' . $type . '&mc=' . $nocache;

    $script = '<link type="text/css" rel="stylesheet" href="' . $href . '" />';

    if ($type == 'js') {
        $script = '<script type="text/javascript" src="' . $href . '"></script>';
    }

    echo $script;
}

