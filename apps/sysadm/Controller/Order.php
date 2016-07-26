<?php
/**
 * 订单管理页面控制器
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

class Controller_Order extends Controller_Base
{
    /**
     * 对换表对象 
     * 
     * @var mixed
     * @access private
     */
    private $orderModel = null;
    /**
     * 服务项表对象 
     * 
     * @var mixed
     * @access private
     */
    private $modelProducts = null;
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
        parent::__construct('Table_Orders');
        /**
         * 实例化订单模型 
         */
        $this->orderModel =& FLEA::getSingleton('Model_Orders');
        /**
         * 实例化会员模型 
         */
        $this->memberModel =& FLEA::getSingleton('Model_Members');
        /**
         * 实例化商品模型 
         */
        $this->modelProducts =& FLEA::getSingleton('Model_Products');
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
             * 按服务项名查找 
             */
            //$name = isset($_POST['name']) ? h(trim($_POST['name'])) : urldecode(h(trim($_GET['name'])));
            //if ($name) {
                //$where[] = array('food.name', '%' . $name . '%', 'like');
                //$data['name'] = $name;
            //}
            /**
             * 按服务项名价格 
             */
            //$price = isset($_POST['price']) ? $_POST['price'] : $_GET['price'];
            //if ($price) {
                //$where[] = array('food.price', $price);
                //$data['price'] = $price;
            //}
            /**
             * 按订单人查找
             */
            $username = isset($_POST['username']) ? h(trim($_POST['username'])) : urldecode(h(trim($_GET['username'])));
            if ($username) {
                $where[] = array('member.username', '%' . $username . '%', 'like');
                $data['username'] = $username;
            }

            $member_id = isset($_POST['member_id']) ? h(trim($_POST['member_id'])) : (int)$_GET['member_id'];
            if ($member_id) {
                $where[] = array('member_id', $member_id);
                $data['member_id'] = $member_id;
            }

            /**
             * 按队换人电话查找 
             */
            //$phone = isset($_POST['phone']) ? trim($_POST['phone']) : trim($_GET['phone']);
            //if ($phone) {
                //$where[] = array('member.phone', $phone);
                //$data['phone'] = $phone;
            //}
        }
        /**
         * 排序 
         */
        $sortby = 'created DESC, order_id ASC';
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
        $tbl = $this->orderModel->getTable();
        /**
         * 载入分页助手 
         */
        FLEA::loadHelper('pager');
        /**
         * 实例化一个分页助手，并将所需数据读取出来存于$data数组中 
         */
        $pager = new FLEA_Helper_Pager($tbl, $page, $pagesize, $where, $sortby);
        $data['pager'] = $pager->getPagerData();
        $data['orders'] = $pager->findAll('*');

        foreach ($data['orders'] as $key => $value) {
            $data['orders'][$key]['member']['params'] = unserialize($value['member']['params']);
            $data['orders'][$key]['params'] = unserialize($value['params']);
            $data['orders'][$key]['params']['bill'] = unserialize($data['orders'][$key]['params']['bill']);
            $data['orders'][$key]['address'] = unserialize($value['address']['address']);
        }
        /**
         * Pagenav 链接构造参数
         */
        $data['controller'] = 'Order';
        $data['action'] = 'Index';
        $data['colkey'] = getColkey();
        $data['lang'] = getLanguage();
        /**
         * 返回上一页 
         */
        $this->_setBack();

        $this->_executeView('modules/order/list.tpl', $data);
    }
    /**
     * 查看订单信息 
     * 
     * @access public
     * @return void
     */
    function actionModify()
    {
        /**
         * 获得订单信息 
         */
        $data['order'] = $this->orderModel->getOne((int)$_GET['id']);
        /**
         * 读取订单内容 
         */
        if ($data['order']['products']) {

            foreach ($data['order']['products'] as $key => $value) {

                $where = array(
                    array('col_key', 'products'),
                    array('lang', getLanguage()),
                    array('pro_id', $value['pro_id'])
                );

                $data['order']['products'][$key] = $this->modelProducts->getOne($where, null, 'pro_id, name, pic, price', false);
                $data['order']['products'][$key]['params'] = unserialize($value['params']);
                $data['order']['products'][$key]['num'] = $value['num'];
            }
        }

        if ($data['order']['params']) {
            $data['order']['params'] = unserialize($data['order']['params']);
            $data['order']['params']['bill'] = unserialize($data['order']['params']['bill']);
            $data['order']['params']['address'] = unserialize($data['order']['params']['address']);
        }

        if ($data['order']['delivery_way']) {
            $data['order']['delivery_way'] = unserialize($data['order']['delivery_way']);
        }

        $modelSetup =& FLEA::getSingleton("Model_Setup");

        $data['deliverys'] = $modelSetup->getAll(array(array('col_key', 'delivery')), null, 'name, params', null, false);
        foreach ($data['deliverys'] as $k => $v) {
            $data['deliverys'][$k]['params'] = unserialize($v['params']);
        }

        /**
         * 设置返回点 
         */
        $this->_setBack();
        $this->_executeView('modules/order/modify-order.tpl', $data);
    }
    /**
     * 设为失效 
     * 
     * @access public
     * @return void
     */
    function actionDisabled()
    {
        /**
         * 设置异常拦截点
         */
        __TRY();
        /**
         * 保存商家
         */
        $this->orderModel->save($_POST);
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
     * 删除订单 
     * 
     * @access public
     * @return void
     */
    function actionRemove()
    {
        /**
         * 按主键删除单个订单
         */
        if ($_GET['id']) {
            $pkvs = array((int)$_GET['id']);
        }
        /**
         * 按主键删除多个订单
         */
        if ($_POST['check']) {
            $pkvs = $_POST['check'];
        }
        /**
         * 设置异常拦截点
         */
        __TRY();
        /**
         * 删除所选订单
         */
        $this->orderModel->removeAll($pkvs);
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

        $this->_executeView('modules/order/search-order.tpl', $data);
    }
    /**
     * 订单属性设置 
     * 
     * @access public
     * @return void
     */
    function actionSetup()
    {
        $optionsModel =& FLEA::getSingleton('Model_Options');

        $data = $optionsModel->getOption();

        $this->_setBack();
        $this->_executeView('modules/order/setup.tpl', $data);
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

