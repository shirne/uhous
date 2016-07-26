<?php
/**
 * 广告管理模块
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Controller
 * @category   Class
 * @author     Jazyone <zhongjintang@gmail.com>
 * @version    $Id$
 **/

class Controller_Advertise extends Controller_Base
{
    /**
     * 广告模型对象 
     * 
     * @var mixed
     * @access private
     */
    private $_advModel = null;   

    function __construct()
    {
        parent::__construct();
        /**
         *  实例化广告管理模型
         */
        $this->_advModel =& FLEA::getSingleton('Model_Advertises');
    }

    /**
     * 广告列表 
     * 
     * @param mixed $data 配置及数据 
     * @access public
     * @return void
     */
    function actionIndex($data = null)
    {
        /**
         * 实例化视图模型 
         */
        $tpl =& $this->_getView();
        //
        //分页查找广告列表数据
        // 
        /**
         * 条件 
         */
        $where = array(
            array('col_key', getColKey()),
            array('lang', getLanguage())
            );

        if ($_GET['search'] == 'yes') {
            /**
             * 搜索标志，用于分页控件 
             */
            $data['search'] = 'yes';

            /**
             * 标题关键字 
             */
            $title = isset($_POST['title']) ? h(trim($_POST['title'])) : urldecode(h(trim($_GET['title'])));
            if ($title) {
                $where[] = array('title', "%{$title}%", 'like');
                $data['title'] = $title;
            }
        }
        /**
         * 排序 
         */
        $sortby = 'sort_id ASC, created DESC';
        /**
         * 获取页码 
         */
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 0;
        /**
         * 设置分页大小 
         */
        $pagesize = 15;
        /**
         * 获取表实例 
         */
        $tbl = $this->_advModel->getTable();
        /**
         * 载入分页助手 
         */
        FLEA::loadHelper('pager');
        /**
         * 实例化一个分页助手，并将所需数据读取出来存于$data数组中 
         */
        $pager = new FLEA_Helper_Pager($tbl, $page, $pagesize, $where, $sortby);
        $data['pager'] = $pager->getPagerData();
        $data['advertises'] = $pager->findAll('adv_id, pic, title, url');

        /**
         * Pagenav 链接构造参数
         */
        $data['controller'] = 'Advertise';
        $data['action'] = 'Index';
        $data['colkey'] = getColkey();
        $data['lang'] = getLanguage();

        $tpl->assign($data);
        $tpl->display('modules/advertise/list.tpl');
    }
    /**
     * 焦点图 
     * 
     * @access public
     * @return void
     */
    function actionFocus($data = null)
    {
        /**
         * 实例化视图 
         */
        $tpl =& $this->_getView();
        /**
         * 实例化表数据入口 
         */
        $adv = $this->_advModel->getTable();
        /**
         * 获得焦点图广告
         */
        $data['advertises'] = $adv->findAll(
            array(
                array('col_key', 'focus')
            ),
            'sort_id ASC, created DESC',
            null,
            'title, pic, adv_id, col_key, url, sort_id',
            false
            );
        /**
         * 构造参数 
         */
        $data['advertise']['col_key'] = 'focus';
        $data['advertise']['lang'] = getLanguage();

        $tpl->assign($data);
        $tpl->display('modules/advertise/list-focus.tpl');
    }
    /**
     * 添加广告 
     * 
     * @access public
     * @return void
     */
    function actionAddAdv()
    {
        $this->_editAdvertise();
    }
    /**
     * 编辑广告 
     * 
     * @access public
     * @return void
     */
    function actionModify()
    {
        $this->_editAdvertise($_GET['id']);
    }
    /**
     * 保存广告 
     * 
     * @access public
     * @return void
     */
    function actionSave()
    {
        /**
         * 设置异常拦截点
         */
        __TRY();
        /**
         * 保存广告
         */
        $this->_advModel->save($_POST);
        /**
         * 获取抛出的异常
         */
        $ex = __CATCH();
        /**
         * 判断是否是一个异常
         */
        if (__IS_EXCEPTION($ex)) {
            js_alert($ex->getMessage(), 0, $this->_getBack());
        }
        /**
         * 返回页面 
         */
        if ($_POST['col_key'] == 'focus') {

            return $this->actionFocus();
        } else {

            return $this->actionIndex();
        }
    }
    /**
     * 删除广告 
     * 
     * @access public
     * @return void
     */
    function actionRemove()
    {
        /**
         * 按主键删除单个广告
         */
        if ($_GET['id']) {
            $pkvs = array((int)$_GET['id']);
        }
        /**
         * 按主键删除多个广告
         */
        if ($_POST['check']) {
            $pkvs = $_POST['check'];
        }
        /**
         * 设置异常拦截点
         */
        __TRY();
        /**
         * 删除所选广告
         */
        $this->_advModel->removeAll($pkvs);
        /**
         * 获取抛出的异常
         */
        $ex = __CATCH();
        /**
         * 判断是否是一个异常
         */
        if (__IS_EXCEPTION($ex)) {
            js_alert($ex->getMessage(), 0, $this->_getBack());
        }
        /**
         * 返回页面 
         */
        if ($_GET['type'] == 'Focus') {

            return $this->actionFocus();
        } else {

            return $this->actionIndex();
        }
    }
    /**
     * 删除广告图片 
     * 
     * @access public
     * @return void
     */
    function actionRemovePic()
    {
        if ($_GET['id']) {
            $pkvs = $_GET['id'];
        }
        /**
         * 设置异常拦截点
         */
        __TRY();
        /**
         * 删除所选广告
         */
        $this->_advModel->removeAdvPic($pkvs);
        /**
         * 获取抛出的异常
         */
        $ex = __CATCH();
        /**
         * 判断是否是一个异常
         */
        if (__IS_EXCEPTION($ex)) {
            js_alert($ex->getMessage(), 0, $this->_getBack());
        }

        return $this->_editAdvertise($pkvs);
    }
    /**
     * 编辑广告信息 
     * 
     * @param mixed $pkv 
     * @access protected
     * @return void
     */
    function _editAdvertise($pkv = null)
    {
        $tpl =& $this->_getView();

        /**
         * 获得操作类型 
         */
        $type = isset($_GET['type']) ? $_GET['type'] : null;

        $adv = $this->_advModel->getTable();

        $data['advertise'] = $adv->find(array(array($adv->primaryKey, $pkv)), null, 'title, pic, url, adv_id, sort_id', false);

        $data['advertise']['col_key'] = ($type == 'Focus') ? "focus" : getColKey();
        $data['advertise']['adv_id'] = $pkv;
        $data['advertise']['lang'] = getLanguage();
        
        $tpl->assign($data);

        if ($type == 'Focus') {

            $tpl->display('modules/advertise/list-focus.tpl');
        } else {

            $tpl->display('modules/advertise/modify-advertise.tpl');
        }
    }
    /**
     * 广告排序视图 
     * 
     * @access public
     * @return void
     */
    function actionSortAdvs()
    {
        $tpl =& $this->_getView();

        $advs = $this->_advModel->getTable();

        $where = array(
            array('col_key', getColKey()),
            array('lang', getLanguage())
            );

        $data['advertises'] = $advs->findAll($where, 'sort_id ASC, created DESC', null, 'adv_id, title', false);

        $this->_setBack();

        $tpl->assign($data);

        $tpl->display('modules/advertise/sort-advertise.tpl');
    }
    /**
     * 保存广告排序结果
     */
    function actionSaveSortAdv()
    {
        /**
         * 设置异常拦截点
         */
        __TRY();
        /**
         * 保存排序
         */
        $this->_advModel->saveSort($_POST['seqNoList']);
        /**
         * 获取抛出的异常
         */
        $ex = __CATCH();
        /**
         * 判断是否是一个异常
         */
        if (__IS_EXCEPTION($ex)) {
            js_alert($ex->getMessage(), 0, $this->_getBack());
        }
        /**
         * 返回上一页面
         */
        $this->_goBack();
    }
    /**
     * 广告搜索 
     * 
     * @access public
     * @return void
     */
    function actionSearch()
    {
        $tpl =& $this->_getView();

        $data['advertise']['col_key'] = getColKey();
        $data['advertise']['lang'] = getLanguage();

        $tpl->assign($data);
        $tpl->display('modules/advertise/search-advertise.tpl');
    }
}
