<?php
/**
 * 会员管理模型
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Model
 * @category   Class
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/

//{{ 载入抽象模型类
FLEA::loadClass('Model_Abstract');
//}}

class Model_Members extends Model_Abstract
{
    function __construct()
    {
        parent::__construct('Table_Member');
    }

    function save(&$row)
    {
        /**
         * 未定义名称 
         
        if (!$row['username']) {
            //{{ 载入异常处理类
            FLEA::loadClass('Exception_Undefined');
            //}}
            // 抛出异常
            __THROW(new Exception_Undefined('用户名称'));
        }*/

        //if (!$row['password']) {
            ////{{ 载入异常处理类
            //FLEA::loadClass('Exception_Undefined');
            ////}}
            //// 抛出异常
            //__THROW(new Exception_Undefined('用户密码'));
        //}
        /**
         * 未定义语言版本
         */
        if (!$row['lang']) {
            //{{ 载入异常处理类
            FLEA::loadClass('Exception_Undefined');
            //}}
            // 抛出异常
            __THROW(new Exception_Undefined('语言版本'));
            return;
        }
        /**
         * 序列化参数 
         */
        $row['params'] = serialize($row['params']);

        if (parent::save(&$row)) {
            return true;
        }

        //{{ 载入异常处理类
        FLEA::loadClass('Exception_Failed');
        //}}
        // 抛出异常
        __THROW(new Exception_Failed('保存会员失败'));
        return;
    }
    /**
     * 删除全部会员
     *
     * @param array $pkvs
     * @access public
     * @return void
     */
    function removeAll($pkvs)
    {
        /**
         * 删除会员
         */
        if (!$this->tbl->removeByPkvs($pkvs)) {
            //{{ 载入异常处理类
            FLEA::loadClass('Exception_Failed');
            //}}
            // 抛出异常
            __THROW(new Exception_Failed('无法删除所选会员'));
            return;
        }
    }
    /**
     * 验证用户数据
     * 
     * @param mixed $username 
     * @param mixed $password 
     * @access public
     * @return void
     */
    function check($username, $password = null, $field="member_id, username, realname, email")
    {
        /**
         * 查询条件
         */
        if(strpos($username,'@')!==false ){
            $where[] = array('email', trim($username));
        }else{
            $where[] = array('username', trim($username));
        }

        if (!empty($password)) {
            $where[] = array('password', md5($password));
        }
        
        /**
         * 获得表数据入口 
         */
        $tbl = $this->getTable();
        /**
         * 返回用户数据
         */
        return $tbl->find($where, null, $field);
    }
    /**
     * 验证用户数据,排除ID
     * 
     * @param mixed $username 
     * @param mixed $id 
     * @access public
     * @return void
     */
    function checkExceptID($username, $id, $field="member_id, username, realname, email")
    {
        /**
         * 查询条件
         */
        $where = "username='$username' AND member_id<>$id";

        /**
         * 获得表数据入口 
         */
        $tbl = $this->getTable();
        /**
         * 返回用户数据
         */
        return $tbl->find($where, null, $field);
    }
    /**
     * 验证用户数据
     * 
     * @param mixed $username 
     * @param mixed $password 
     * @access public
     * @return void
     */
    function checkData($value, $key, $field="member_id, username, realname, email")
    {
        /**
         * 查询条件
         */
        $where[] = array($key, trim($value));

        /**
         * 获得表数据入口 
         */
        $tbl = $this->getTable();
        /**
         * 返回用户数据
         */
        return $tbl->find($where, null, $field);
    }
    /**
     * 验证用户数据,排除固定ID
     * 
     * @param string $value 
     * @param string $key 
     * @param int $id
     * @access public
     * @return void
     */
    function checkDataExceptID($value, $key, $id, $field="member_id,realname, username, email")
    {
    	$id=intval($id);
    	$value=mysql_escape_string($value);
        /**
         * 查询条件
         */
        $where[] = "`$key`='$value' AND member_id<>$id";

        /**
         * 获得表数据入口 
         */
        $tbl = $this->getTable();
        /**
         * 返回用户数据
         */
        return $tbl->find($where, null, $field);
    }
}

