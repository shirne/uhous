<?php
/**
 * 广告表数据入口类
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Controller
 * @category   Class
 * @author     Jazyone <zhongjintang@gmail.com>
 * @version    $Id$
 **/

//{{ 载入类
FLEA::loadClass('FLEA_Db_TableDataGateway');
//}}

class Table_Advertises extends FLEA_Db_TableDataGateway
{
    /**
     * 广告表表名 
     */
    public $tableName = 'advertise';

    /**
     * 广告表主键 
     */
    public $primaryKey = 'adv_id';
}
