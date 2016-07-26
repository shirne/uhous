<?php
/**
 * 订单数据表
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

class Table_Orders extends FLEA_Db_TableDataGateway
{
    /**
     * 街道表名 
     * 
     * @var string
     * @access public
     */
    public $tableName = 'orders';
    /**
     * 主键 
     * 
     * @var string
     * @access public
     */
    public $pirmaryKey = 'order_id';
    /**
     * 从属关系
     *
     * @var array
     * @access public
     */
    public $belongsTo = array(
        // 所属会员
        array(
            'tableClass' => 'Table_Member',
            'foreignKey' => 'member_id',
            'mappingName' => 'member',
            'fields' => array(
                'member_id',
                'username',
                'params',
                'address'
            )
        ),
        // 所属收货地址
        array(
            'tableClass' => 'Table_Address',
            'foreignKey' => 'add_id',
            'mappingName' => 'address',
            'fields' => array(
                'add_id',
                'username',
                'address',
                'tel',
                'phone',
                'post',
                'email',
                'building',
                'besttime'
            )
        )
    );

    /**
     * 一对多关系
     *
     * @var array
     * @access public
     */
    public $hasMany = array(
        // 商品
        array(
            'tableClass' => 'Table_Orderproduct',
            'foreignKey' => 'order_id',
            'mappingName' => 'products',
            'fields' => array(
                'id_key',
                'pro_id',
                'num',
                'commented',
                'params'
            )
        )
    );
}
?>
