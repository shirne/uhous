<?php
/**
 * 兑换管理页面控制器
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Controller
 * @category   Class
 * @author     Jazyone <zhongjintang@gmail.com>
 * @version    $Id$
 **/

//{{ 载入类
FLEA::loadClass('Controller_Base');
//}}

class Controller_Exchange extends Controller_Base
{
    /**
     * 对换表对象 
     * 
     * @var mixed
     * @access private
     */
    private $exchangeModel = null;
    /**
     * 物品表对象 
     * 
     * @var mixed
     * @access private
     */
    private $prizesModel = null;
    /**
     * 会员表对象 
     * 
     * @var mixed
     * @access private
     */
    private $memberModel = null;
    /**
     * 构造函数 
     * 
     * @access protected
     * @return void
     */
    function __construct()
    {
        /**
         * 实例化对换表数据入口 
         */
        parent::__construct('Table_Exchange');
        /**
         * 实例化兑换模型 
         */
        $this->exchangeModel =& FLEA::getSingleton('Model_Exchange');
        /**
         * 实例化物品模型 
         */
        $this->prizesModel =& FLEA::getSingleton('Model_Prizes');
        /**
         * 实例化会员模型 
         */
        $this->memberModel =& FLEA::getSingleton('Model_Members');
    }

    function actionIndex()
    {
        /**
         * 条件 
         */
        $where = array(
            array('col_key', getColKey()),
            array('lang', getLanguage())
            );
        /**
         * 搜索部分 
         */
        if ($_GET['search'] == 'yes') {
            /**
             * 搜索标志，用于分页控件 
             */
            $data['search'] = 'yes';
            /**
             * 按物品名查找 
             */
            $name = isset($_POST['name']) ? h(trim($_POST['name'])) : urldecode(h(trim($_GET['name'])));
            if ($name) {
                $where[] = array('prize.name', '%' . $name . '%', 'like');
                $data['title'] = $name;
            }
            /**
             * 按兑换物品所需积分查找 
             */
            $points = isset($_POST['points']) ? $_POST['points'] : $_GET['points'];
            if ($points) {
                $where[] = array('prize.points', $_POST['points']);
                $data['points'] = $points;
            }
            /**
             * 按兑换人查找
             */
            $username = isset($_POST['username']) ? h(trim($_POST['username'])) : urldecode(h(trim($_GET['name'])));
            if ($username) {
                $where[] = array('member.username', '%' . $username . '%', 'like');
                $data['username'] = $username;
            }
            /**
             * 按队换人电话查找 
             */
            $phone = isset($_POST['phone']) ? $_POST['phone'] : $_GET['phone'];
            if ($_POST['phone']) {
                $where[] = array('member.phone', $_POST['phone'], 'like');
                $data['phone'] = $phone;
            }
        }
        /**
         * 排序 
         */
        $sortby = 'exc_id DESC, created DESC';
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
        $tbl = $this->exchangeModel->getTable();
        /**
         * 载入分页助手 
         */
        FLEA::loadHelper('pager');
        /**
         * 实例化一个分页助手，并将所需数据读取出来存于$data数组中 
         */
        $pager = new FLEA_Helper_Pager($tbl, $page, $pagesize, $where, $sortby);
        $data['pager'] = $pager->getPagerData();
        $data['exchanges'] = $pager->findAll('prize_id, member_id, state, exc_id, created');
        /**
         * Pagenav 链接构造参数
         */
        $data['controller'] = 'Exchange';
        $data['action'] = 'Index';
        $data['colkey'] = getColkey();
        $data['lang'] = getLanguage();
        /**
         * 返回上一页 
         */
        $this->_setBack();

        $this->_executeView('modules/exchange/list.tpl', $data);
    }
    /**
     * 查看兑换信息 
     * 
     * @access public
     * @return void
     */
    function actionModify()
    {
        /**
         * 获得兑换信息 
         */
        $data['exchange'] = $this->exchangeModel->getOne((int)$_GET['id']);
        /**
         * 设置返回点 
         */
        $this->_setBack();
        $this->_executeView('modules/exchange/modify-exchange.tpl', $data);
    }
    /**
     * 设为已兑换 
     * 
     * @access public
     * @return void
     */
    function actionSetExchanged()
    {
        /**
         * 设置异常拦截点
         */
        __TRY();
        /**
         * 保存商家
         */
        $this->exchangeModel->save($_POST);
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
         * 返回上一页 
         */
        $this->_goBack();
    }
    /**
     * 删除兑换 
     * 
     * @access public
     * @return void
     */
    function actionRemove()
    {
        /**
         * 按主键删除单个兑换
         */
        if ($_GET['id']) {
            $pkvs = array((int)$_GET['id']);
        }
        /**
         * 按主键删除多个兑换
         */
        if ($_POST['check']) {
            $pkvs = $_POST['check'];
        }
        /**
         * 设置异常拦截点
         */
        __TRY();
        /**
         * 删除所选兑换
         */
        $this->exchangeModel->removeAll($pkvs);
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

        $this->_goBack();
    }

    function actionSearch()
    {
        /**
         * 构造参数 
         */
        $data['colkey'] = getColKey();
        $data['lang'] = getLanguage();

        $this->_executeView('modules/exchange/search-exchange.tpl', $data);
    }
    /**
     * 物品管理
     * ------------------------------------------------------------- 
     */
    /**
     * 物品列表
     * 
     * @access public
     * @return void
     */
    function actionPrize()
    {
        $where = array(
            array('col_key', getColKey()),
            array('lang', getLanguage())
            );
        /**
         * 搜索部分 
         */
        /**
         * 按物品id搜索 
         */
        if ($_POST['prize_id']) {
            $where[] = array('prize_id', $_POST['prize_id']);
            $data['prize_id'] = $_POST['prize_id'];
        }
        /**
         * 按兑换该物品所需积分搜索 
         */
        if ($_POST['points']) {
            $where[] = array('points', $_POST['points']);
            $data['points'] = $_POST['points'];
        }
        /**
         * 按物品名称搜索 
         */
        $name = isset($_POST['name']) ? h(trim($_POST['name'])) : urldecode(h(trim($_GET['name'])));
        if ($name) {
            $where[] = array('name', '%' . $name . '%', 'like');
            $data['name'] = $name;
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
        $tbl = $this->prizesModel->getTable();
        /**
         * 载入分页助手 
         */
        FLEA::loadHelper('pager');
        /**
         * 实例化一个分页助手，并将所需数据读取出来存于$data数组中 
         */
        $pager = new FLEA_Helper_Pager($tbl, $page, $pagesize, $where, $sortby);
        $data['pager'] = $pager->getPagerData();
        $data['prizes'] = $pager->findAll('name, points, created, amount, prize_id');
        /**
         * Pagenav 链接构造参数
         */
        $data['controller'] = 'Exchange';
        $data['action'] = 'Prize';
        $data['colkey'] = getColkey();
        $data['lang'] = getLanguage();
        /**
         * 设置返回点 
         */
        $this->_setBack();

        $this->_executeView('modules/exchange/prize.tpl', $data);
    }

    function actionAddPrize()
    {
        /**
         * 获得分类表数据入口 
         */
        $tbl = $this->prizesModel->getTable();
        /**
         * 获得分类表元数据
         */
        $data['prize'] = $this->_prepareData($tbl->meta);
        $data['prize']['lang'] = getLanguage();
        $data['prize']['col_key'] = getColkey();

        $this->_setBack();
        /**
         * 编辑物品信息 
         */
        $this->_executeView('modules/exchange/modify-prize.tpl', $data);
    }

    function actionModifyPrize()
    {
        $data['prize'] = $this->prizesModel->getOne((int)$_GET['id']);
        /**
         * 设置返回点 
         */
        $this->_setBack();
        /**
         * 编辑物品信息 
         */
        $this->_executeView('modules/exchange/modify-prize.tpl', $data);
    }
    /**
     * 保存物品 
     * 
     * @access public
     * @return void
     */
    function actionSavePrize()
    {
        /**
         * 设置异常拦截点
         */
        __TRY();
        /**
         * 保存商家
         */
        $this->prizesModel->save($_POST);
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
         * 返回上一页 
         */
        $this->_goBack();
    }
    /**
     * 删除物品 
     * 
     * @access public
     * @return void
     */
    function actionRemovePrize()
    {
        /**
         * 按主键删除单个商家
         */
        if ($_GET['id']) {
            $pkvs = array((int)$_GET['id']);
        }
        /**
         * 按主键删除多个商家
         */
        if ($_POST['check']) {
            $pkvs = $_POST['check'];
        }
        /**
         * 设置异常拦截点
         */
        __TRY();
        /**
         * 删除所选商家
         */
        $this->prizesModel->removeAll($pkvs);
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
         * 返回上一页 
         */
        $this->_goBack();
    }
    /**
     * 删除物品图片 
     * 
     * @access public
     * @return void
     */
    function actionRemovePrizePic()
    {
        if ($_GET['id']) {
            $pkvs = (int)$_GET['id'];
        }
        /**
         * 设置异常拦截点
         */
        __TRY();
        /**
         * 删除所选商家
         */
        $this->prizesModel->removePic($pkvs);
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
         * 返回上一页 
         */
        $this->_goBack();
    }
    /**
     * 物品搜索 
     * 
     * @access public
     * @return void
     */
    function actionSearchPrize()
    {
        /**
         * 构造参数 
         */
        $data['colkey'] = getColKey();
        $data['lang'] = getLanguage();

        $this->_executeView('modules/exchange/search-prize.tpl', $data);
    }
    /**
     * 兑换属性设置 
     * 
     * @access public
     * @return void
     */
    function actionSetup()
    {
        $optionsModel =& FLEA::getSingleton('Model_Options');

        $data = $optionsModel->getOption();

        $this->_setBack();
        $this->_executeView('modules/exchange/setup.tpl', $data);
    }
    /**
     * 保存属性设置 
     * 
     * @access public
     * @return void
     */
    function actionSaveSetup()
    {
        $optionsModel =& FLEA::getSingleton('Model_Options');
        /**
         * 设置异常拦截点
         */
        __TRY();
        /**
         * 保存会员资料
         */
        $optionsModel->setOptions($_POST);
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
}

