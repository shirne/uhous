<?php
/**
 * 节点未找到
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Exception
 * @category   Class
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/

class Exception_NodeNotFound extends FLEA_Exception
{
    /**
     * 构造函数
     * 
     * @access public
     * @return Exception
     */
    function __construct($node_id)
    {
        /**
         * 抛出异常
         */
        parent::FLEA_Exception(sprintf('操作失败, 未选择要操作的 %d 节点!', $node_id));
    }
}

