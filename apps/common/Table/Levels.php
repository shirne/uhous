<?php
/**
 * 等级表数据入口类
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Table
 * @category   Class
 * @author     Jayzone <zhongjintang@gmail.com>
 * @version    $Id$
 **/

//{{ 载入表数据入口基类
FLEA::loadClass('FLEA_Db_TableDataGateway');
//}}

class Table_Levels extends FLEA_Db_TableDataGateway
{
    /**
     * 表名
     * 
     * @var string
     * @access public
     */
    public $tableName = 'level';
    /**
     * 主键
     * 
     * @var string
     * @access public
     */
    public $primaryKey = 'level_id';
}

