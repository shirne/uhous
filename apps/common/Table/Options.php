<?php
/**
 * 系统配置表数据入口类
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

class Table_Options extends FLEA_Db_TableDataGateway
{
    /**
     * 表名
     *
     * @var string
     * @access public
     */
    public $tableName = 'options';
    /**
     * 主键
     *
     * @var string
     * @access public
     */
    public $primaryKey = 'opt_id';
}

