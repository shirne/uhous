<?php
/**
 * 应用于权限设置的栏目复选框视图控件
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    WebControl
 * @category   Function
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/

function _ctlColumncheckbox($name, $attribs)
{
    $opts = array('value', 'checked');
    $data = FLEA_WebControls::extractAttribs($attribs, $opts);

    $checked = 0;

    if ($data['checked']) {
        $checked = in_array($data['value'], $data['checked']) ? $data['value'] : 0;
    }

    return getControl('Checkbox', $name, array('value' => $data['value'], 'checked' => $checked));
}

