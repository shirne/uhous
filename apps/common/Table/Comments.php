<?php
/**
 * 评论记录表数据入口
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Table
 * @category   Class
 * @author     jayzone <zhongjintang@gmail.com>
 * @version    $Id$
 **/

//{{ 载入表数据入口基类
FLEA::loadClass('FLEA_Db_TableDataGateway');
//}}

class Table_Comments extends FLEA_Db_TableDataGateway
{
    /**
     * 表名
     * 
     * @var string
     * @access public
     */
    public $tableName = 'comments';
    /**
     * 主键
     * 
     * @var string
     * @access public
     */
    public $primaryKey = 'com_id';
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
                'address',
                'email'
            )
        ),
        // 所属商品
        array(
            'tableClass' => 'Table_Products',
            'foreignKey' => 'pro_id',
            'mappingName' => 'products',
            'fields' => array(
                'pro_id',
                'name',
                'price',
                'pic',
                'cate_id',
                'points'
            )
        )
    );
}
