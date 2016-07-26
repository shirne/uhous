<?php
/**
 * 会员表数据入口类
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

class Table_Member extends FLEA_Db_TableDataGateway
{
    /**
     * 表名
     * 
     * @var string
     * @access public
     */
    public $tableName = 'members';
    /**
     * 主键
     * 
     * @var string
     * @access public
     */
    public $primaryKey = 'member_id';
     /**
     * 从属关系
     *
     * @var array
     * @access public
     */
    public $belongsTo = array(
        // 所属分类
        array(
            'tableClass' => 'Table_Levels',
            'foreignKey' => 'level_id',
            'mappingName' => 'level',
            'fields' => array(
                'level_id',
                'levels'
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
        // 食品
        /*array(
            'tableClass' => 'Table_Carts',
            'foreignKey' => 'member_id',
            'mappingName' => 'carts',
            'fields' => array(
                'cart_id',
                'pro_id'
            )
        ),*/
        array(
            'tableClass' => 'Table_Address',
            'foreignKey' => 'member_id',
            'mappingName' => 'addresses',
            'fields' => array(
                'add_id',
                'member_id',
                'username',
                'default',
                'address',
                'phone',
                'tel',
                'post',
                'building',
                'besttime'
            )
        ),
        array(
            'tableClass' => 'Table_Membercoupon',
            'foreignKey' => 'member_id',
            'mappingName' => 'coupons',
            'fields' => array(
                'member_id',
                'cou_id',
                'status',
                'invaluetime',
                'sn'
            )
        ),
        array(
            'tableClass' => 'Table_Fav',
            'foreignKey' => 'member_id',
            'mappingName' => 'favs',
            'fields' => array(
                'member_id',
                'pro_id',
                'created'
            )
        )
    );
    /**
     * 创建之前
     *
     * @param array $row
     * @access public
     * @return array
     */
    public function _beforeCreate(&$row)
    {
        return $this->_md5Password(&$row);
    }
    /**
     * 更新之前
     *
     * @param array $row
     * @access public
     * @return array
     */
    public function _beforeUpdate(&$row)
    {
        return $this->_md5Password(&$row);
    }
    /**
     * Md5密码
     *
     * @param array $row
     * @access private
     * @return array
     */
    private function _md5Password(&$row)
    {
        if ($row['password']) {
            $row['password'] = md5($row['password']);
        } else {
            unset($row['password']);
        }
        return $row;
    }
}

