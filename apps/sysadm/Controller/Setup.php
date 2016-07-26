<?php
/**
 * 配置管理控制器
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Controller
 * @category   Class
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/

class Controller_Setup extends Controller_Base
{
    /**
     * 配置管理模型实例
     *
     * @var Model_Setup
     * @access private
     */
    private $modelSetup;
    /**
     * 分类管理模型实例
     *
     * @var Model_Setup
     * @access private
     */
    private $modelCate;
    /**
     * 构造函数
     */
    function __construct()
    {
        /**
         * 执行父类构造函数
         */
        parent::__construct();
        /**
         * 实例化配置管理模型
         */
        $this->modelSetup =& FLEA::getSingleton('Model_Setup');
        /**
         * 实例化分类管理模型
         */
        $this->modelCate =& FLEA::getSingleton('Model_Categories');
    }

    /**
     * 配置列表视图
     */
    function actionIndex()
    {
        /**
         * 设置查询条件
         */
        $where = array(
            'col_key' => getColkey(),
            'lang' => getLanguage()
        );
        /**
         * 搜索
         */
        if ($_GET['search']) {
            /**
             * 搜索标识符，用于分页控件
             */
            $data['search'] = 'yes';

            /**
             * 按标题搜索
             */
            $title = isset($_POST['title']) ? h(trim($_POST['title'])) : urldecode(h(trim($_GET['title'])));
            if ($title) {
                $where[] = array('title', "%{$title}%", 'like');
                /**
                 * Pagenav 链接构造参数
                 */
                $data['title'] = urlencode($title);
            }

            /**
             * 按配置ID搜索
             */
            $set_id = isset($_POST['set_id']) ? (int)$_POST['set_id'] : (int)$_GET['set_id'];
            if ($set_id > 0) {
                $where[] = array('set_id', $set_id);
                /**
                 * Pagenav 链接构造参数
                 */
                $data['set_id'] = $set_id;
            }

        } 
        /**
         * 设置排序方式
         */
        $sortby = 'sort_id ASC, set_id ASC';
        /**
         * 获取页码 
         */
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 0;
        /**
         * 设置分页大小 
         */
        $pagesize = 18;
        /**
         * 获取表实例 
         */
        $tbl = $this->modelSetup->getTable();
        /**
         * 载入分页助手 
         */
        FLEA::loadHelper('pager');
        /**
         * 实例化一个分页助手，并将所需数据读取出来存于$data数组中 
         */
        $pager = new FLEA_Helper_Pager($tbl, $page, $pagesize, $where, $sortby);
        $data['pager'] = $pager->getPagerData();
        $data['setups'] = $pager->findAll('set_id, name, memo, cost');

        foreach ($data['setups'] as $key => $value) {
            $data['setups'][$key]['params'] = unserialize($value['params']);
        }
        /**
         * Pagenav 链接构造参数
         */
        $data['controller'] = 'Setup';
        $data['action'] = 'Index';
        $data['col_key'] = getColkey();
        $data['lang'] = getLanguage();
        /**
         * 设置当前视图为返回视图
         */
        $this->_setBack();
        /**
         * 输出配置列表视图
         */
        $this->_executeView('modules/setup/list.tpl', $data);
    }
    /**
     * 发布配置视图
     */
    function actionAddNew()
    {
        /**
         * 获得配置表数据入口操作句柄
         */
        $tbl =& $this->modelSetup->getTable();
        /**
         * 获得配置表元数据
         */
        $data['setup'] = $this->_prepareData($tbl->meta);
        $data['setup']['lang'] = getLanguage();
        $data['setup']['col_key'] = getColkey();
        /**
         * 设置当前视图为返回视图
         */
        $this->_setBack();
        /**
         * 输出编辑配置视图
         */
        $this->_editSetup($data);
    }

    /**
     * 编辑配置视图
     */
    function actionModify()
    {
        /**
         * 查询配置数据
         */
        $data['setup'] = $this->modelSetup->getOne((int)$_GET['id']);

        $data['setup']['params'] = unserialize($data['setup']['params']);
        /**
         * 设置当前视图为返回视图
         */
        $this->_setBack();
        /**
         * 输出编辑配置视图
         */
        $this->_editSetup($data);
    }

    /**
     * 保存配置
     */
    function actionSave()
    {
        /**
         * 设置异常拦截点
         */
        __TRY();
        /**
         * 保存分类
         */
        $this->modelSetup->save(&$_POST);
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
     * 删除配置
     */
    function actionRemove()
    {
        /**
         * 按主键删除单个配置
         */
        if ($_GET['id']) {
            $pkvs = array((int)$_GET['id']);
        }
        /**
         * 按主键删除多个配置
         */
        if ($_POST['check']) {
            $pkvs = $_POST['check'];
        }
        /**
         * 设置异常拦截点
         */
        __TRY();
        /**
         * 删除所选配置
         */
        $this->modelSetup->removeAll($pkvs);
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
     * 配置编辑视图
     *
     * @param array $row
     * @access protected
     * @return void
     */
    protected function _editSetup(&$row)
    {
        /**
         * 输出分类编辑视图
         */
        $this->_executeView('modules/setup/modify-setup.tpl', $row);
    }

    function actionPayment()
    {
        $this->actionIndex();
    }

    function actionDelivery()
    {
        $this->actionIndex();
    }
    /**
     * 设置排序视图 
     * 
     * @access public
     * @return void
     */
    function actionSort()
    {
        $tpl =& $this->_getView();

        $advs = $this->modelSetup->getTable();

        $where = array(
            array('col_key', getColKey()),
            array('lang', getLanguage())
            );

        $data['setups'] = $advs->findAll($where, 'sort_id ASC, set_id ASC', null, 'set_id, name, sort_id', false);

        $this->_setBack();

        $tpl->assign($data);

        $tpl->display('modules/setup/sort-setup.tpl');
    }
    /**
     * 保存优惠券排序结果
     */
    function actionSaveSort()
    {
        /**
         * 设置异常拦截点
         */
        __TRY();
        /**
         * 保存排序
         */
        $this->modelSetup->saveSort($_POST['seqNoList']);
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
     * 区域设置
     */
    // -------------------------------------------------------------------

    /**
     * 产品区域视图
     */
    function actionArea()
    {
        /**
         * 获得区域树
         */
        $data['categories'] = $this->modelCate->getTree(0, 'cate_id, parent_id, name, created');
        /**
         * 设置当前视图为返回视图
         */
        $this->_setBack();
        /**
         * 输出产品区域列表视图
         */
        $this->_executeView('modules/setup/area.tpl', $data);
    }

    /**
     * 添加区域视图
     */
    function actionAddNewArea()
    {
        /**
         * 获得区域表数据入口操作句柄
         */
        $tbl =& $this->modelCate->getTable();
        /**
         * 获得区域表元数据
         */
        $data['category'] = $this->_prepareData($tbl->meta);
        $data['category']['lang'] = getLanguage();
        $data['category']['col_key'] = getColkey();
        /**
         * 设置当前视图为返回视图
         */
        $this->_setBack();
        /**
         * 输出编辑区域视图
         */
        $this->_editArea($data);
    }

    /**
     * 修改产品区域视图
     */
    function actionModifyArea()
    {
        /**
         * 查询区域数据
         */
        $data['category'] = $this->modelCate->getOne((int)$_GET['id']);
        /**
         * 设置当前视图为返回视图
         */
        $this->_setBack();
        /**
         * 输出编辑区域视图
         */
        $this->_editArea($data);
    }

    /**
     * 保存区域
     */
    function actionSaveArea()
    {
        /**
         * 设置异常拦截点
         */
        __TRY();
        /**
         * 保存区域
         */
        $this->modelCate->save($_POST);
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
     * 删除产品区域
     */
    function actionRemoveAreas()
    {
        /**
         * 按主键删除单个区域
         */
        if ($_GET['id']) {
            $pkvs = array((int)$_GET['id']);
        }
        /**
         * 按主键删除多个区域
         */
        if ($_POST['check']) {
            $pkvs = $_POST['check'];
        }
        /**
         * 设置异常拦截点
         */
        __TRY();
        /**
         * 删除所选区域
         */
        $this->modelCate->removeAll($pkvs);
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
     * 产品区域排序视图
     */
    function actionSortAreas()
    {
        /**
         * 获父类ID
         */
        $parent_id = isset($_GET['parent_id']) ? (int)$_GET['parent_id'] : 0;
        /**
         * 获得区域列表
         */
        $data['categories'] = $this->modelCate->getTopCates($parent_id);
        /**
         * 当没有区域数据时，给出提示并返回上一视图
         */
        if (!$data['categories']) {
            js_alert('没有可排序的区域', 0, $this->_getBack());
        }
        /**
         * 获得顶级区域列表
         */
        $data['topCategories'] = $this->modelCate->getTopCates();
        /**
         * 设置当前视图为返回视图
         */
        $this->_setBack();
        /**
         * 输出产品区域排序视图
         */
        $this->_executeView('modules/setup/sort-area.tpl', $data);
    }

    /**
     * 保存产品区域排序结果
     */
    function actionSaveSortAreas()
    {
        /**
         * 设置异常拦截点
         */
        __TRY();
        /**
         * 保存排序
         */
        $this->modelCate->saveSort($_POST['seqNoList']);
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
     * 编辑产品区域
     *
     * @param array $data
     * @access private
     * @return void
     */
    private function _editArea(&$data)
    {
        /**
         * 获得区域树
         */
        //$data['categories'] = $this->modelCate->getTopCates();
        $data['categories'] = $this->modelCate->getTree(0, 'cate_id, parent_id, name, created');
        /**
         * 输出产品编辑视图
         */
        $this->_executeView('modules/setup/modify-area.tpl', $data);
    }
    /**
     * 邀请范文设置 
     * 
     * @access public
     * @return void
     */
    function actionInvitation()
    {
        $modelOptions =& FLEA::getSingleton('Model_Options');

        $invitation1 = $modelOptions->getOption('invitation1');
        $invitation2 = $modelOptions->getOption('invitation2');
        $invitation3 = $modelOptions->getOption('invitation3');

        $data['invitation1'] = $invitation1['invitation1']['value'];
        $data['invitation2'] = $invitation2['invitation2']['value'];
        $data['invitation3'] = $invitation3['invitation3']['value'];

        $this->_setBack();
        $this->_executeView("modules/setup/invitation.tpl", $data);
    }
}

