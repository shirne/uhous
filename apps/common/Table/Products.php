<?php
/**
 * 商品表数据入口类
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Table
 * @category   Class
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/

//{{ 载入表数据入口类
FLEA::loadClass('FLEA_Db_TableDataGateway');
//}}

class Table_Products extends FLEA_Db_TableDataGateway
{
    /**
     * 表名
     * 
     * @var string
     * @access public
     */
    public $tableName = 'products';
    /**
     * 主键
     * 
     * @var string
     * @access public
     */
    public $primaryKey = 'pro_id';
    /**
     * 从属关系
     *
     * @var array
     * @access public
     */
    public $belongsTo = array(
        // 所属分类
        array(
            'tableClass' => 'Table_Categories',
            'foreignKey' => 'cate_id',
            'mappingName' => 'category',
            'fields' => array(
                'cate_id',
                'name'
            )
        ),
        // 所属品牌
        array(
            'tableClass' => 'Table_Brands',
            'foreignKey' => 'brand_id',
            'mappingName' => 'brand',
            'fields' => array( 'brand_id', 'name', 'pic', 'logo','memo', 'intro', 'minpic')
        )
    );
    /**
     * 一对多关系
     *
     * @var array
     * @access public
     */
    public $hasMany = array(
        // 商品副图
        array(
            'tableClass' => 'Table_Photos',
            'foreignKey' => 'pro_id',
            'mappingName' => 'photos',
            'fields' => array(
                'photo_id',
                'name',
                'pic'
            )
        ),
        // 商品评论
        array(
            'tableClass' => 'Table_Comments',
            'foreignKey' => 'pro_id',
            'mappingName' => 'comments',
            'fields' => array(
                'com_id',
                'title',
                'memo',
                'created',
                'points'
            )
        )

    );
}

