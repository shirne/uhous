<?php
/**
 * 邮箱验证信息数据入口类
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

class Table_Checkcode extends FLEA_Db_TableDataGateway
{
    /**
     * 地址表表名 
     */
    public $tableName = 'checkcode';

    /**
     * 地址表主键 
     */
    public $primaryKey = 'code_id';
}
