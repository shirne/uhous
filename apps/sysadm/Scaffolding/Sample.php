<?php
/**
 * 简单脚手架
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Scaffolding
 * @category   Class
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/

class Scaffolding_Sample extends Controller_Base
{
    /**
     * 脚手架基本路径
     *
     * @var string
     * @access protected
     */
    protected $_baseDir = null;
    /**
     * 表数据入口类
     *
     * @var TableDataGatway
     * @access protected
     */
    protected $_tdg = null;
    /**
     * 表数据入口名称
     *
     * @var string
     * @access protected
     */
    protected $_tdgName = null;
    /**
     * 构造函数
     *
     * @access protected
     */
    function __construct($table = null)
    {
        /**
         * 执行父类构造函数
         */
        parent::__construct();
        /**
         * 存入脚手架基本路径
         */
        define('SCAFF_DIR', dirname(__FILE__));
        /**
         * 实例化表数据入口类
         */
        if ($table) {
            $this->_tdg =& FLEA::getSingleton($table);
            $this->_tdgName = $table;
        }
    }
    /**
     * 字段列表
     *
     * @access public
     * @return void
     */
    function actionIndex()
    {
        /**
         * 设置当前视图为返回页面
         */
        $this->_setBack();
        /**
         * 获得字段集
         */
        $data['fields'] = $this->getFields();
        /**
         * 获得数据集
         */
        $data['rows'] = $this->getRows();
        /**
         * 获得表主键
         */
        $data['pkv'] = $this->_tdg->primaryKey;
        /**
         * 输出视图
         */
        include SCAFF_DIR . DS . 'View/list.php';
    }
    /**
     * 创建记录
     *
     * @access public
     * @return void
     */
    function actionCreate()
    {
        /**
         * 设置当前视图为返回页面
         */
        $this->_setBack();
        /**
         * 获得字段集
         */
        $data['fields'] = $this->_prepareData($this->_tdg->meta);
        /**
         * 编辑记录
         */
        $this->_editFields($data);
    }
    /**
     * 编辑记录
     *
     * @access public
     * @return void
     */
    function actionEdit()
    {
        /**
         * 设置当前视图为返回页面
         */
        $this->_setBack();
        /**
         * 获得字段集
         */
        $data['fields'] = $this->_tdg->find((int)$_GET[$this->_tdg->primaryKey]);
        /**
         * 编辑记录
         */
        $this->_editFields($data);
    }
    /**
     * 记录编辑视图
     *
     * @param mixed $row 
     * @access protected
     * @return void
     */
    protected function _editFields($data)
    {
        /**
         * 输出视图
         */
        include SCAFF_DIR . DS . 'View/edit.php';
    }
    /**
     * 保存记录
     *
     * @access public
     * @return void
     */
    function actionSave()
    {
        $msg = 'Fail!';
        if ($this->_tdg->save($_POST)) {
            $msg = 'Success!';
        }
        /**
         * 返回消息
         */
        js_alert($msg, null, $this->_getBack());
    }
    /**
     * 删除记录
     *
     * @access public
     * @return void
     */
    function actionDelete()
    {
        $msg = 'Fail!';
        if ($this->_tdg->removeByPkv((int)$_GET[$this->_tdg->primaryKey])) {
            $msg = 'Success!';
        }
        /**
         * 返回消息
         */
        js_alert($msg, null, $this->_getBack());
    }
    /**
     * 获得字段集
     *
     * @access private
     * @return array
     */
    private function getFields()
    {
        return $this->_tdg->fields;
    }
    /**
     * 获得数据集
     *
     * @access private
     * @return void
     */
    private function getRows()
    {
        return $this->_tdg->findAll();
    }
}

