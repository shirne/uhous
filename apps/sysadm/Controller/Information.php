<?php
/**
 * 信息管理控制器
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Controller
 * @category   Class
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/

class Controller_Information extends Controller_Base
{
    /**
     * 信息管理模型实例
     *
     * @var Model_Information
     * @access private
     */
    private $modelInformation;
    /**
     * 产品分类管理模型实例
     *
     * @var Model_Categories
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
         * 实例化信息管理模型
         */
        $this->modelInformation =& FLEA::getSingleton('Model_Information');
        /**
         * 实例化产品分类管理模型
         */
        $this->modelCate =& FLEA::getSingleton('Model_Categories');
    }

    /**
     * 信息列表视图
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
             * 按信息ID搜索
             */
            $info_id = isset($_POST['info_id']) ? (int)$_POST['info_id'] : (int)$_GET['info_id'];
            if ($info_id > 0) {
                $where[] = array('info_id', $info_id);
                /**
                 * Pagenav 链接构造参数
                 */
                $data['info_id'] = $info_id;
            }

        } 
        /**
         * 设置排序方式
         */
        $sortby = 'created DESC, info_id ASC';
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
        $tbl = $this->modelInformation->getTable();
        /**
         * 载入分页助手 
         */
        FLEA::loadHelper('pager');
        /**
         * 实例化一个分页助手，并将所需数据读取出来存于$data数组中 
         */
        $pager = new FLEA_Helper_Pager($tbl, $page, $pagesize, $where, $sortby);
        $data['pager'] = $pager->getPagerData();
        $data['informations'] = $pager->findAll('info_id, title, pic, created');
        /**
         * Pagenav 链接构造参数
         */
        $data['controller'] = 'Information';
        $data['action'] = 'Index';
        $data['colkey'] = getColkey();
        $data['lang'] = getLanguage();
        /**
         * 设置当前视图为返回视图
         */
        $this->_setBack();
        /**
         * 输出信息列表视图
         */
        $this->_executeView('modules/information/list.tpl', $data);
    }

    /**
     * 发布信息视图
     */
    function actionAddNew()
    {
        /**
         * 获得信息表数据入口操作句柄
         */
        $tbl =& $this->modelInformation->getTable();
        /**
         * 获得信息表元数据
         */
        $data['information'] = $this->_prepareData($tbl->meta);
        $data['information']['lang'] = getLanguage();
        $data['information']['col_key'] = getColkey();
        /**
         * 设置当前视图为返回视图
         */
        $this->_setBack();
        /**
         * 输出编辑信息视图
         */
        $this->_editInformation($data);
    }

    /**
     * 编辑信息视图
     */
    function actionModify()
    {
        /**
         * 查询信息数据
         */
        $data['information'] = $this->modelInformation->getOne((int)$_GET['id']);
        /**
         * 设置当前视图为返回视图
         */
        $this->_setBack();
        /**
         * 输出编辑信息视图
         */
        $this->_editInformation($data);
    }

    /**
     * 保存信息
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
        $this->modelInformation->save(&$_POST);
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
     * 删除信息
     */
    function actionRemove()
    {
        /**
         * 按主键删除单个信息
         */
        if ($_GET['id']) {
            $pkvs = array((int)$_GET['id']);
        }
        /**
         * 按主键删除多个信息
         */
        if ($_POST['check']) {
            $pkvs = $_POST['check'];
        }
        /**
         * 设置异常拦截点
         */
        __TRY();
        /**
         * 删除所选信息
         */
        $this->modelInformation->removeAll($pkvs);
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
     * 删除信息中的图片
     */
    function actionRemovePic()
    {
        /**
         * 设置异常拦截点
         */
        __TRY();
        /**
         * 删除信息中的图片
         */
        $this->modelInformation->removeInfoPic((int)$_GET['id']);
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
     * 搜索信息视图
     */
    function actionSearch()
    {
        /**
         * 获得语言版本及栏目标识
         */
        $data['colkey'] = getColkey();
        $data['lang'] = getLanguage();
        /**
         * 输出信息搜索视图
         */
        $this->_executeView('modules/information/search-informations.tpl', $data);
    }
    /**
     * 信息编辑视图
     *
     * @param array $row
     * @access protected
     * @return void
     */
    protected function _editInformation(&$row)
    {
        /**
         * 获得分类树
         */
        $row['categories'] = $this->modelCate->getTree();
        /**
         * 输出分类编辑视图
         */
        $this->_executeView('modules/information/modify-information.tpl', $row);
    }
    
    // -------------------------------------------------------------------

    /**
     * 信息分类视图
     */
    function actionCategories()
    {
        /**
         * 获得分类树
         */
        $data['categories'] = $this->modelCate->getTree(0, 'cate_id, parent_id, name, created');
        /**
         * 设置当前视图为返回视图
         */
        $this->_setBack();
        /**
         * 输出信息分类列表视图
         */
        $this->_executeView('modules/information/categories.tpl', $data);
    }

    /**
     * 添加信息分类视图
     */
    function actionAddNewCategory()
    {
        /**
         * 获得分类表数据入口操作句柄
         */
        $tbl =& $this->modelCate->getTable();
        /**
         * 获得分类表元数据
         */
        $data['category'] = $this->_prepareData($tbl->meta);
        $data['category']['lang'] = getLanguage();
        $data['category']['col_key'] = getColkey();
        /**
         * 设置当前视图为返回视图
         */
        $this->_setBack();
        /**
         * 输出编辑分类视图
         */
        $this->_editCategory($data);
    }

    /**
     * 修改信息分类视图
     */
    function actionModifyCategory()
    {
        /**
         * 查询分类数据
         */
        $data['category'] = $this->modelCate->getOne((int)$_GET['id']);
        /**
         * 设置当前视图为返回视图
         */
        $this->_setBack();
        /**
         * 输出编辑分类视图
         */
        $this->_editCategory($data);
    }

    /**
     * 保存信息分类
     */
    function actionSaveCategory()
    {
        /**
         * 设置异常拦截点
         */
        __TRY();
        /**
         * 保存分类
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
     * 删除信息分类
     */
    function actionRemoveCategories()
    {
        /**
         * 按主键删除单个分类
         */
        if ($_GET['id']) {
            $pkvs = array((int)$_GET['id']);
        }
        /**
         * 按主键删除多个分类
         */
        if ($_POST['check']) {
            $pkvs = $_POST['check'];
        }
        /**
         * 设置异常拦截点
         */
        __TRY();
        /**
         * 删除所选分类
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
     * 信息分类排序视图
     */
    function actionSortCategories()
    {
        /**
         * 获父类ID
         */
        $parent_id = isset($_GET['parent_id']) ? (int)$_GET['parent_id'] : 0;
        /**
         * 获得分类列表
         */
        $data['categories'] = $this->modelCate->getTopCates($parent_id);
        /**
         * 当没有分类数据时，给出提示并返回上一视图
         */
        if (!$data['categories']) {
            js_alert('没有可排序的分类', 0, $this->_getBack());
        }
        /**
         * 获得顶级分类列表
         */
        $data['topCategories'] = $this->modelCate->getTopCates();
        /**
         * 设置当前视图为返回视图
         */
        $this->_setBack();
        /**
         * 输出信息分类排序视图
         */
        $this->_executeView('modules/information/sort-categories.tpl', $data);
    }

    /**
     * 保存信息分类排序结果
     */
    function actionSaveSortCategories()
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
     * 编辑信息分类
     *
     * @param array $data
     * @access private
     * @return void
     */
    private function _editCategory(&$data)
    {
        /**
         * 获得分类树
         */
        $data['categories'] = $this->modelCate->getTopCates();
        /**
         * 输出信息编辑视图
         */
        $this->_executeView('modules/information/modify-category.tpl', $data);
    }
}

