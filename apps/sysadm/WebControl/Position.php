<?php
/**
 * 当前位置页面控件
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    WebControl
 * @category   Function
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/

function _ctlPosition($name, $attribs)
{
    $opts = array('position', 'column', 'footprint');
    $data = FLEA_WebControls::extractAttribs( $attribs, $opts );
    FLEA_WebControls::mergeAttribs( $attribs );

    // 是否输出语言版本位置
    $lang = true;

    // 定义分割符
    $split = ' &rsaquo; ';

    $code = '
        <div id="position">
        <p><strong>当前位置 : </strong>';

    // 输出当前语言版本
    if ($lang) {
        $code .= getLanguage('name') . $split;
    }
    $code .= $data['column'] . $split;

    if ($data['footprint']) {
        // 实例化栏目模型
        $model= FLEA::getSingleton('Model_Columns');
        // 获取栏目ID
        $column = $model->getOneByColkey(null, 'col_id');
        $code .= $model->getFootPrint($column['col_id'], $split) . $split;
        // 回收内存
        unset($model, $column);
    }
    $code .= '<span>' . $data['position'] . '</span></p>
            </div>';

    return $code;
}

