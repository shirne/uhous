<?php
/**
 * 指定用户/集不存在
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Exception
 * @category   Class
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/

class Exception_UsersNotFound extends FLEA_Exception
{
    /**
     * 用户ID集
     * 
     * @var string
     * @access private
     */
    private $userIds = null;
    /**
     * 构造函数
     * 
     * @param array $userIds 
     * @access public
     * @return Exception
     */
    function __construct($userIds)
    {
        /**
         * 将数组转移为字符串
         */
        $this->userIds = implode(',', $userIds);
        /**
         * 抛出异常
         */
        parent::FLEA_Exception(sprintf('操作失败, 编号为(%s)的用户不存在!', $this->userIds));
    }
}

