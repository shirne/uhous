<?php
/**
 * 清空缓存助手
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Helper
 * @category   Function
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/

function Helper_ClearCache($label = '', $dir = null, $fileType = '*')
{
    ob_start();
    if ($label) {
        echo $label . "\n";
    }
    /**
     * 删除目录下的文件
     */
    foreach (new RecursiveDirectoryIterator($dir) as $i => $d)
    {
        if (sprintf($d) != '..' &&
            sprintf($d) != '.' &&
            sprintf($d) != $dir . DS . '..' &&
            sprintf($d) != $dir . DS . '.'
        ) {
            if (@unlink(sprintf($d))) {
                echo $d . " => 删除成功!  \n";
            } else {
                echo $d . " => 删除失败!  \n";
            }
        }
    }
    echo "SUCCESSED.";
    $content = ob_get_clean();
    echo htmlspecialchars($content);
}

