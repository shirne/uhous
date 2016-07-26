<?php
/**
 * 订单关系表
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

class Table_Orderproduct extends FLEA_Db_TableDataGateway
{
    /**
     * 数据表名 
     * 
     * @var string
     * @access public
     */
    public $tableName = 'order_has_product';
    /**
     * 主键 
     * 
     * @var string
     * @access public
     */
    public $primaryKey = 'id_key';
    /**
     * 一对一关系
     *
     * @var array
     * @access public
     */
    public $belongsTo = array(
        // 一条订单商品记录对应一件商品
        array(
            'tableClass' => 'Table_Products',
            'foreignKey' => 'pro_id',
            'mappingName' => 'product',
            'fields' => array(
                'pro_id',
                'name',
                'price',
                'cate_id',
                'pic'
            )
        )
    );
}
