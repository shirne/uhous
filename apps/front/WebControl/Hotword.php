<?php
/**
 * 热门搜索词格式化控件
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    WebControl
 * @category   Function
 * @author     jayzone <zhongjintang@gmail.com>
 * @version    $Id$
 **/

function _ctlHotword($name, $attribs)
{
    $opts = array();
    $data = FLEA_WebControls::extractAttribs($attribs, $opts);
    /**
     * 读取热门词 
     */
    $hotword = getOption('hot');
    $hotword = explode(" ", $hotword);
    /**
     * 输出热门词 
     */
    if ($hotword) {
        foreach ($hotword as $key => $word) {
            $output .= '<a href="' . url('Merchant', null, array('keyword' => $word)) . '" title="' . $word . '">' . $word . '</a> ';
        }
    }
    return $output;
}

