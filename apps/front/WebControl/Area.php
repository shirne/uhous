<?php
/**
 * 地区选择控件
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    WebControl
 * @category   Function
 * @author     jayzone <zhongjintang@gmail.com>
 * @version    $Id$
 **/

function _ctlArea($name, $attribs)
{
    $opts = array('displayLabel', 'label', 'prov_id', 'city_id');
    $data = FLEA_WebControls::extractAttribs($attribs, $opts);
    FLEA_WebControls::mergeAttribs( $attribs );

    if (!$data['prov_id']) {
        $data['prov_id'] = 0;
    }

    if (!$data['city_id']) {
        $data['city_id'] = 0;
    }


    $modelCategory =& FLEA::getSingleton('Model_Categories');

    $tree = $modelCategory->getTopCates(0, 'cate_id, parent_id, name, created', 'area');

    if ($data['label'] != 'no') {
        $output .= '<label>';
    }
    if ($data['displayLabel'] == 'yes') {
        $output .= '<span>选择地区：</span>';
    }

    if ($data['city_id']) {
        $output .= '<select onchange="selectArea(this.value, \'city\', '.$data['city_id'].');" id="province" tabindex="5"">';
    } else {
        $output .= '<select onchange="selectArea(this.value, \'city\');" id="province" tabindex="5"">';
    }
    
    $output .= '<option value="">请选择省份</option>';
    
    foreach ($tree as $tk => $top) {
        $output .= '<option ';
        if ($data['prov_id'] == $top['cate_id']) {
            $output .= 'selected="selected"';
        }
        $output .= ' value='.$top['cate_id'].'>'.$top['name'].'</option>';
    }
    $output .= '</select>';
    if ($data['label'] != 'no') {
        $output .= '</label>';
    }

    return $output;
}
