<?php
/**
 * 会员优惠券关系表
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Table
 * @category   Class
 * @author     Jazyone <zhongjintang@gmail.com>
 * @version    $Id$
 **/

//{{ 载入类
FLEA::loadClass('FLEA_Db_TableDataGateway');
//}}

class Table_Membercoupon extends FLEA_Db_TableDataGateway
{
    /**
     * 数据表名 
     * 
     * @var string
     * @access public
     */
    public $tableName = 'member_has_coupon';
    /**
     * 主键 
     * 
     * @var string
     * @access public
     */
    public $primaryKey = 'id';
    
    public $belongsTo=array(
        array(
            'tableClass' => 'Table_Coupons',
            'foreignKey' => 'cou_id',
            'mappingName' => 'coupon',
            'fields' => array(
                'cou_id',
                'name',
                'value',
                'minprice',
                'invaluetype',
                'pic',
                'exprise',
                'period'
            )
        )
    );
}
