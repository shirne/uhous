<?php
/**
 * 收藏表数据入口类
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Table
 * @category   Class
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/

//{{ 载入表数据入口基类
FLEA::loadClass('FLEA_Db_TableDataGateway');
//}}

class Table_Fav extends FLEA_Db_TableDataGateway
{
    /**
     * 表名
     * 
     * @var string
     * @access public
     */
    public $tableName = 'member_has_fav';
    /**
     * 主键
     * 
     * @var string
     * @access public
     */
    public $primaryKey = 'fav_id';
    /**
     * 一对一关系
     *
     * @var array
     * @access public
     */
    public $belongsTo = array(
        // 一条收藏记录对应一件商品
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

