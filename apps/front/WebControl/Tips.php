<?php
/**
 * 商家数提示
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    WebControl
 * @category   Function
 * @author     jayzone <zhongjintang@gmail.com>
 * @version    $Id$
 **/

function _ctlTips($name, $attribs)
{
    $opts = array();
    $data = FLEA_WebControls::extractAttribs($attribs, $opts);

    $merchantModel =& FLEA::getSingleton('Table_Merchants');

    $total = $merchantModel->findCount(array(array('col_key', 'merchant')), 'merc_id');

    $newsMerc = $merchantModel->find(array(array('col_key', 'merchant')), 'created DESC', 'merc_id, name', false);

    $link = '<a href="' . url("Merchant", null, array('rmd' => 1, 'id' => $newsMerc['merc_id'])) . '">'. $newsMerc['name'] .'</a>';

    $output = "<span class=\"fr\">已有 {$total} 个店铺加入   最新加入 \"{$link}\" </span>";

    return $output;
}

