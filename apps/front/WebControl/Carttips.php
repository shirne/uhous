<?php
/**
 * 购物车数量提示控件
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    WebControl
 * @category   Function
 * @author     jayzone <zhongjintang@gmail.com>
 * @version    $Id$
 **/

function _ctlCarttips($name, $attribs)
{
    $opts = array('id', 'name');
    $data = FLEA_WebControls::extractAttribs($attribs, $opts);
    FLEA_WebControls::mergeAttribs( $attribs );

    //if ($data['id']) {

        //$modelCarts =& FLEA::getSingleton('Model_Carts');

        //$where = array(
            //array('col_key', 'member'),
            //array('lang', getLanguage()),
            //array('member_id', $data['id'])
        //);

        //$num = $modelCarts->getTable()->findCount($where, null, '*');

    //} else {

        $num = count($_SESSION['carts']);

    //}

    if ($num!=0) {
        return "({$num})";
    } else {
        return;
    }
}

