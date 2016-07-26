<?php
/**
 * 留言表数据入口
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

class Table_Messages extends FLEA_Db_TableDataGateway
{
    /**
     * 留言表名 
     * 
     * @var string
     * @access public
     */
    public $tableName = 'messages';
    /**
     * 主键 
     * 
     * @var string
     * @access public
     */
    public $pirmaryKey = 'msg_id';
    /**
     * 从属关系 
     * 
     * @var array
     * @access public
     */
    public $belongsTo = array(
        'tableClass' => 'Table_Member',
        'foreignKey' => 'member_id',
        'mappingName' => 'member',
        'fields' => array(
            'member_id',
            'username',
            'params'
            )
        );
}
