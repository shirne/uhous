<?php
/**
 * 语言版本跳转页面控件
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    WebControl
 * @category   Function
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/

function _ctlLanguages($name, $attribs)
{
    $opts = array('options');
    $data = FLEA_WebControls::extractAttribs( $attribs, $opts );

    // 读出系统支持的语言版本
    $languages = FLEA::getAppInf('languages');

    if ($languages) {
        // 输出控件内容
        $output = '<span>语言版本: </span>';

        $output .= '<select id="lang-jump" name="lang-jump">';

        foreach ($languages as $value => $lang) {
            $output .= '<option value="' . $value. '"';
            if ($name == $value) {
                $output .= ' selected="selected"';
            }
            $output .= '>' . $lang. '</option>';
        }

        $output .= '</select>';

        $output .= '<script type="text/javascript">var url="' . url('Dashboard') . '";</script>';
    }

    return $output;
}

