<?php
/**
 * 抽象模型类
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Model
 * @category   Abstract Class
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/

abstract class Model_Abstract
{
    /**
     * 表数据入口类实例
     * 
     * @var FLEA_Db_TableDataGatway
     * @access protected
     */
    protected $tbl;
    /**
     * 表数据字段
     *
     * @var string
     * @access protected
     */
    protected $fields = '*';
    /**
     * 构造函数
     * 
     * @param string $table 表数据入口类名称
     * @access public
     * @return void
     */
    function __construct($table = null)
    {
        if ($table) {
            $this->tbl =& FLEA::getSingleton($table);
        }
    }
    /**
     * 获得全部符合查询条件的记录
     * 
     * @param mixed $where 查询条件
     * @param mixed $orderby 排序
     * @param string $fields 查询字段
     * @param mixed $limit 查询数量
     * @access public
     * @return array
     */
    function getAll($where = null, $orderby = null, $fields = null, $limit = null, $links = true)
    {
        /**
         * 设置查询字段
         */
        if (is_null($fields)) {
            $fields = $this->fields;
        }
        /**
         * 返回记录集
         */
        return $this->tbl->findAll($where, $orderby, $limit, $fields, $links);
    }
    /**
     * 获得一条符合查询条件的记录
     * 
     * @param mixed $where 查询条件
     * @param mixed $orderby 排序
     * @param string $fields 查询字段
     * @access public
     * @return array
     */
    function getOne($where = null, $orderby = null, $fields = null, $links = true)
    {
        /**
         * 设置查询字段
         */
        if (is_null($fields)) {
            $fields = $this->fields;
        }
        /**
         * 返回记录
         */
        return $this->tbl->find($where, $orderby, $fields, $links);
    }
    /**
     * 按栏目标识获得多条记录
     *
     * @param mixed $colkey
     * @param mixed $fields
     * @param mixed $orderby
     * @param mixed $limit
     * @access public
     * @return array
     */
    function getAllByColkey($colkey = null, $fields = null, $orderby = null, $limit = null, $links = true)
    {
        /**
         * 设置查询字段
         */
        if (is_null($fields)) {
            $fields = $this->fields;
        }
        /**
         * 设置栏目标识
         */
        if (!$colkey) {
            $colkey = getColkey();
        }
        /**
         * 查询条件
         */
        $where = array(
            array('lang', getLanguage()),
            array('col_key', $colkey)
        );
        return $this->tbl->findAll($where, $orderby, $limit, $fields, $links);
    }
    /**
     * 按栏目标识获得一条记录
     *
     * @param mixed $colkey
     * @param mixed $fields
     * @param mixed $orderby
     * @access public
     * @return array
     */
    function getOneByColkey($colkey = null, $fields = null, $orderby = null)
    {
        /**
         * 设置查询字段
         */
        if (is_null($fields)) {
            $fields = $this->fields;
        }
        /**
         * 设置栏目标识
         */
        if (!$colkey) {
            $colkey = getColkey();
        }
        /**
         * 查询条件
         */
        $where = array(
            array('lang', getLanguage()),
            array('col_key', $colkey)
        );
        return $this->tbl->find($where, $orderby, $fields);
    }
    /**
     * 保存记录
     * 
     * @param array $data 记录数据
     * @access public
     * @return boolean
     */
    function save(&$data)
    {
        /**
         * 返回保存记录后的返回结果
         */
        return $this->tbl->save(&$data);
    }
    /**
     * 删除记录
     * 
     * @param int $pkv 记录主键
     * @access public
     * @return boolean
     */
    function remove($pkv)
    {
        /**
         * 返回删除记录后的返回结果
         */
        return $this->tbl->removeByPkv($pkv);
    }
    /**
     * 返回表数据入口实例
     * 
     * @access public
     * @return $tbl FLEA_Db_TableDataGatway
     */
    function & getTable()
    {
        return $this->tbl;
    }
}

