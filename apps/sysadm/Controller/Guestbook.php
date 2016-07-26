<?php
/**
 * 留言管理页面控制器
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

class Controller_Guestbook extends Controller_Base
{
    /**
     * 对换表对象 
     * 
     * @var mixed
     * @access private
     */
    private $messageModel = null;
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
        parent::__construct('Table_Messages');
        /**
         * 实例化留言模型 
         */
        $this->messageModel =& FLEA::getSingleton('Model_Messages');
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
             * 按留言标题查找 
             */
            $title = isset($_POST['title']) ? h(trim($_POST['title'])) : urldecode(h(trim($_GET['title'])));
            if ($title) {
                $where[] = array('title', '%' . $title . '%', 'like');
                $data['title'] = $title;
            }
            /**
             * 按留言人查找
             */
            $username = isset($_POST['username']) ? h(trim($_POST['username'])) : urldecode(h(trim($_GET['username'])));
            if ($username) {
                $where[] = array('member.username', '%' . $username . '%', 'like');
                $data['username'] = $username;
            }
            /**
             * 按队换人电话查找 
             */
            $phone = isset($_POST['phone']) ? trim($_POST['phone']) : trim($_GET['phone']);
            if ($phone) {
                $where[] = array('member.phone', $phone);
                $data['phone'] = $phone;
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
        $tbl = $this->messageModel->getTable();
        /**
         * 载入分页助手 
         */
        FLEA::loadHelper('pager');
        /**
         * 实例化一个分页助手，并将所需数据读取出来存于$data数组中 
         */
        $pager = new FLEA_Helper_Pager($tbl, $page, $pagesize, $where, $sortby);
        $data['pager'] = $pager->getPagerData();
        $data['messages'] = $pager->findAll('member_id, msg_id, created, title, dismiss');
        /**
         * Pagenav 链接构造参数
         */
        $data['controller'] = 'Guestbook';
        $data['action'] = 'Index';
        $data['colkey'] = getColkey();
        $data['lang'] = getLanguage();
        /**
         * 返回上一页 
         */
        $this->_setBack();

        $this->_executeView('modules/guestbook/list.tpl', $data);
    }
    /**
     * 查看留言信息 
     * 
     * @access public
     * @return void
     */
    function actionModify()
    {
        /**
         * 获得留言信息 
         */
        $data['message'] = $this->messageModel->getOne((int)$_GET['id']);
        /**
         * 设置返回点 
         */
        $this->_setBack();
        $this->_executeView('modules/guestbook/modify-message.tpl', $data);
    }
    /**
     * 删除留言 
     * 
     * @access public
     * @return void
     */
    function actionRemove()
    {
        /**
         * 按主键删除单个留言
         */
        if ($_GET['id']) {
            $pkvs = array((int)$_GET['id']);
        }
        /**
         * 按主键删除多个留言
         */
        if ($_POST['check']) {
            $pkvs = $_POST['check'];
        }
        /**
         * 设置异常拦截点
         */
        __TRY();
        /**
         * 删除所选留言
         */
        $this->messageModel->removeAll($pkvs);
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
    /**
     * 留言搜索视图 
     * 
     * @access public
     * @return void
     */
    function actionSearch()
    {
        /**
         * 构造参数 
         */
        $data['colkey'] = getColKey();
        $data['lang'] = getLanguage();

        $this->_executeView('modules/guestbook/search-message.tpl', $data);
    }

    function actionSaveReply()
    {
        if ($_POST['pass'] || $_POST['sub_reply']) {
            $pass = 1;
        }

        if ($_POST['dismiss']) {
            $pass = 0;
        }

        if ($_POST['sub_reply'] || $_POST['pass'] || $_POST['dismiss']) {

            $reply = $_POST['reply'];
            $msg_id = isset($_POST['msg_id']) ? trim($_POST['msg_id']) : null;

            /**
            * 设置异常拦截点
            */
            __TRY();
            $tbl = $this->messageModel->getTable();

            $tbl->updateField(array(array('msg_id', $msg_id)), 'reply', $reply);

            $tbl->updateField(array(array('msg_id', $msg_id)), 'dismiss', $pass);
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
    }
}
