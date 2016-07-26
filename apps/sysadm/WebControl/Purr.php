<?php
/**
 * Purr消息提示控件
 * @TODO 图标状态区分
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    WebControl
 * @category   Function
 * @author     Allen <movoin@gmail.com>
 * @version    $Id: Purr.php 2 2010-04-27 16:47:43Z allen $
 **/

function _ctlPurr($name, $attribs)
{
    $opts = array('message');
    $data = FLEA_WebControls::extractAttribs( $attribs, $opts );
    FLEA_WebControls::mergeAttribs( $attribs );

    $output = '';


    if ($data['message']) {
        $output = '<div id="' . $name . '" title="' . $data['message']['title'] . '">' . $data['message']['description'] . '</div>';
    }

    return $output;
}

