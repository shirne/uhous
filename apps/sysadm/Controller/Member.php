<?php
/**
 * 会员管理控制器
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Controller
 * @category   Class
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/

class Controller_Member extends Controller_Base
{
    /**
     * 会员管理模型实例
     *
     * @var Model_Members
     * @access private
     */
    private $modelMember;
    /**
     * 会员等级模型 
     * 
     * @var mixed
     * @access private
     */
    private $modelLevel;
    /**
     * 收货地址模型实例 
     * 
     * @var mixed
     * @access private
     */
    private $modelAddress;

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
         * 实例化会员管理模型
         */
        $this->modelMember =& FLEA::getSingleton('Model_Members');
        /**
         * 实例化会员等级模型
         */
        $this->modelLevel =& FLEA::getSingleton('Model_Levels');
        /**
         * 实例化收货地址模型 
         */
        $this->modelAddress =& FLEA::getSingleton('Model_Address');
    }

    /**
     * 会员列表视图
     */
    function actionIndex()
    {
        /**
         * 设置查询条件
         */
        $where = array(
            array('col_key', getColkey()),
            array('lang', getLanguage())
        );
        /**
         * 搜索
         */
        if ($_GET['search'] == 'yes') {
            /**
             * 搜索标识符，用于分页控件
             */
            $data['search'] = 'yes';
            /**
             * 按会员名称搜索
             */
            $name = isset($_POST['username']) ? h(trim($_POST['username'])) : urldecode(h(trim($_GET['username'])));
            if ($name) {
                $where[] = array('username', "%{$name}%", 'like');
                /**
                 * Pagenav 链接构造参数
                 */
                $data['username'] = urlencode($name);
            }

            /**
             * 按ID搜索
             */
            $member_id = isset($_POST['member_id']) ? (int)$_POST['member_id'] : (int)$_GET['member_id'];
            if ($member_id > 0) {
                $where[] = array('member_id', $member_id);
                /**
                 * Pagenav 链接构造参数
                 */
                $data['member_id'] = $member_id;
            }

        } 
        /**
         * 获取页码
         */
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 0;
        /**
         * 设置分页大小
         */
        $pagesize = 15;
        /**
         * 设置排序
         */
        $sortby = 'member_id DESC';
        /**
         * 获取表实例
         */
        $tbl =& $this->modelMember->getTable();
        /**
         * 载入分页助手
         */
        FLEA::loadHelper('pager');
        /**
         * 实例化一个分页助手，并将所需数据读取出来存于$data数组中
         */
        $pager = new FLEA_Helper_Pager($tbl, $page, $pagesize, $where, $sortby);
        $data['pager'] = $pager->getPagerData();
        $data['members'] = $pager->findAll('member_id, username, points, email, created');
        /**
         * Pagenav 链接构造参数
         */
        $data['controller'] = 'Member';
        $data['action'] = 'Index';
        $data['colkey'] = getColkey();
        $data['lang'] = getLanguage();
        /**
         * 设置当前视图为返回视图
         */
        $this->_setBack();
        /**
         * 输出产品列表视图
         */
        $this->_executeView('modules/members/member.tpl', $data);
    }

    /**
     * 添加会员视图
     */
    function actionAddNew()
    {
        /**
         * 获得会员表数据入口操作句柄
         */
        $tbl =& $this->modelMember->getTable();
        /**
         * 获得会员表元数据
         */
        $data['member'] = $this->_prepareData($tbl->meta);
        $data['member']['lang'] = getLanguage();
        $data['member']['col_key'] = getColkey();
        /**
         * 设置当前视图为返回视图
         */
        $this->_setBack();
        /**
         * 输出编辑会员资料视图
         */
        $this->_editMember(&$data);
    }

    /**
     * 修改会员视图
     */
    function actionModify()
    {
        /**
         * 获得会员资料
         */
        $data['member'] = $this->modelMember->getOne((int)$_GET['id']);
        /**
         * 反序列化 
         */
        $data['member']['params'] = unserialize($data['member']['params']);
        /**
         * 实例化优惠券模型
         */
        $modelCoupons =& FLEA::getSingleton('Model_Coupons');
        /**
         * 查找现有的优惠券种类
         */
        $data['coupons'] = $modelCoupons->getAll(null, 'sort_id DESC, cou_id ASC', 'cou_id, name, value, period');

        $array = array();

        if (isset($data['member']['coupons'][1])) {

            foreach ($data['member']['coupons'] as $key) {
                $array = array_merge_recursive($array, $key);
            }

            foreach ($array as $key => $v) {
                $content[$key] = array_count_values($v);
            }

            foreach ($content['cou_id'] as $key => $value) {
                $data['hascoupons']['type'][$key] = $modelCoupons->getOne(array(array('cou_id', $key)), null, 'cou_id, name, value');
                $data['hascoupons']['type'][$key]['count'] = $value;
                $data['hascoupons']['total'] += $data['hascoupons']['type'][$key]['value']*$value;
            }

        } else {

            $data['hascoupons']['type'][] = $modelCoupons->getOne(array(array('cou_id', $data['coupons'][0]['cou_id'])), 'cou_id, name, value');
            $data['hascoupons']['type'][0]['count'] = 1;
            $data['hascoupons']['total'] = $data['hascoupons']['type'][0]['value'];
        }

        /**
         * 设置当前视图为返回视图
         */
        $this->_setBack();
        /**
         * 输出编辑会员资料视图
         */
        $this->_editMember(&$data);
    }

    /**
     * 删除会员
     */
    function actionRemove()
    {
        /**
         * 按主键删除单个会员
         */
        if ($_GET['id']) {
            $pkvs = array((int)$_GET['id']);
        }
        /**
         * 按主键删除多个会员
         */
        if ($_POST['check']) {
            $pkvs = $_POST['check'];
        }
        /**
         * 设置异常拦截点
         */
        __TRY();
        /**
         * 删除所选会员
         */
        $this->modelMember->removeAll($pkvs);
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
     * 保存会员资料
     */
    function actionSave()
    {
        /**
         * 设置异常拦截点
         */
        __TRY();

        $row = $_POST;
        /**
         * 保存会员资料
         */
        $this->modelMember->save($_POST);
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
     * 搜索会员视图
     */
    function actionSearch()
    {
    	$data=array();
        /**
         * 将数据转换为哈希表
         */
        //$data['plans'] = array_to_hashmap($plans, 'label', 'plan_id');
        /**
         * 输出会员搜索视图
         */
        $this->_executeView('modules/members/search-member.tpl', $data);
    }

    /**
     * 会员管理属性设置 
     * 
     * @access public
     * @return void
     */
    function actionSetup()
    {
        $optionsModel =& FLEA::getSingleton('Model_Options');

        $data = $optionsModel->getOption();

        $this->_setBack();
        $this->_executeView('modules/members/setup.tpl', $data);
    }

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

    /**
     * 编辑会员资料
     *
     * @param array $data
     * @access private
     * @return void
     */
    private function _editMember(&$data)
    {
        $data['levels'] = $this->modelLevel->getAll(
            array(
                array('col_key', getColkey()),
                array('lang', getLanguage())
                ),
                'sort_id ASC, level_id DESC',
                'level_id, levels',
                null,
                false
            );
        /**
         * 输出会员资料编辑视图
         */
        $this->_executeView('modules/members/modify-member.tpl', $data);
    }

    /**
     * 会员等级
     */
    function actionLevel()
    {
        /**
         * 获得等级信息
         */
        $data['levels'] = $this->modelLevel->getAll(
            array(
                array('col_key', getColkey()),
                array('lang', getLanguage())
                ),
            "level_id ASC",
            'level_id, levels, created',
            null,
            false
        );
        /**
         * 设置当前视图为返回视图
         */
        $this->_setBack();
        /**
         * 输出信息等级列表视图
         */
        $this->_executeView('modules/members/levels.tpl', $data);
    }

    /**
     * 添加信息等级视图
     */
    function actionAddNewLevel()
    {
        /**
         * 获得等级表数据入口操作句柄
         */
        $tbl =& $this->modelLevel->getTable();
        /**
         * 获得等级表元数据
         */
        $data['level'] = $this->_prepareData($tbl->meta);
        $data['level']['lang'] = getLanguage();
        $data['level']['col_key'] = getColkey();
        /**
         * 设置当前视图为返回视图
         */
        $this->_setBack();
        /**
         * 输出编辑等级视图
         */
        $this->_editLevel($data);
    }

    /**
     * 修改信息等级视图
     */
    function actionModifyLevel()
    {
        /**
         * 查询等级数据
         */
        $data['level'] = $this->modelLevel->getOne((int)$_GET['id']);
        /**
         * 设置当前视图为返回视图
         */
        $this->_setBack();
        /**
         * 输出编辑等级视图
         */
        $this->_editLevel($data);
    }

    /**
     * 保存信息等级
     */
    function actionSaveLevel()
    {
        /**
         * 设置异常拦截点
         */
        __TRY();
        /**
         * 保存等级
         */
        $this->modelLevel->save($_POST);
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
     * 删除信息等级
     */
    function actionRemoveLevels()
    {
        /**
         * 按主键删除单个等级
         */
        if ($_GET['id']) {
            $pkvs = array((int)$_GET['id']);
        }
        /**
         * 按主键删除多个等级
         */
        if ($_POST['check']) {
            $pkvs = $_POST['check'];
        }
        /**
         * 设置异常拦截点
         */
        __TRY();
        /**
         * 删除所选等级
         */
        $this->modelLevel->removeAll($pkvs);
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
     * 信息等级排序视图
     */
    function actionSortLevels()
    {
        /**
         * 获得等级列表
         */
        $data['topCategories'] = $this->modelLevel->getAll(
            array(
                array('col_key', getColkey()),
                array('lang', getLanguage())
                ),
            "sort_id ASC,level_id ASC",
            'level_id, levels, created, sort_id',
            null,
            false
        );
        /**
         * 当没有等级数据时，给出提示并返回上一视图
         */
        if (!$data['topCategories']) {
            js_alert('没有可排序的等级', 0, $this->_getBack());
        }
        /**
         * 设置当前视图为返回视图
         */
        $this->_setBack();
        /**
         * 输出信息等级排序视图
         */
        $this->_executeView('modules/members/sort-levels.tpl', $data);
    }

    /**
     * 保存信息等级排序结果
     */
    function actionSaveSortLevels()
    {
        /**
         * 设置异常拦截点
         */
        __TRY();
        /**
         * 保存排序
         */
        $this->modelLevel->saveSort($_POST['seqNoList']);
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
     * 编辑信息等级
     *
     * @param array $data
     * @access private
     * @return void
     */
    private function _editLevel(&$data)
    {
        /**
         * 获得等级树
         */
        $data['Levels'] = $this->modelLevel->getAll(
            array(
                array('col_key', getColkey()),
                array('lang', getLanguage())
                ),
            "level_id ASC",
            'level_id, levels, created, sort_id',
            null,
            false
        );
        /**
         * 输出信息编辑视图
         */
        $this->_executeView('modules/members/modify-Levels.tpl', $data);
    }

    /**
     * 收货地址管理
     * ------------------------------------------------------------- */

    /**
     * 收货地址管理 
     * 
     * @access public
     * @return void
     */
    public function actionAddress()
    {
    	$data=array();
        /**
         * 设置当前视图为返回视图
         */
        $this->_setBack();
        /**
         * 输出编辑会员收货地址视图
         */
        $this->_editAddress($data);
    }
    /**
     * 编辑收货地址 
     * 
     * @access public
     * @return void
     */
    public function actionModifyAddr()
    {
        /**
         * 获得收获地址 
         */
        $data['addrs'] = $this->modelAddress->getOne((int)$_GET['add_id']);

        if ($data['addrs']) {
            $data['addrs']['address'] = unserialize($data['addrs']['address']);
        }
        /**
         * 设置当前视图为返回视图
         */
        $this->_setBack();
        /**
         * 输出编辑会员收货地址视图
         */
        $this->_editAddress($data);
    }
    /**
     * 保存地址信息
     */
    public function actionSaveAddr()
    {
        /**
         * 设置异常拦截点
         */
        __TRY();


        $row = $_POST;

        $tmp = array(
            'address' => array(
                'address' => $row['address'],
                'province' => $row['province'],
                'city' => $row['city'],
                'division' => $row['division'],
            )
        );

        $row['address'] = serialize($tmp['address']);
        /**
         * 保存等级
         */
        $this->modelAddress->save($row);
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
     * 设置默认地址 
     * 
     * @access public
     * @return void
     */
    public function actionSetAddrDefault()
    {
        /**
         * 按主键设置美食
         */
        if ($_GET['add_id']) {
            $pkvs = $_GET['add_id'];
        }
        /**
         * 设置异常拦截点
         */
        __TRY();
        /**
         * 获得表数据入口
         */
        $tbl = $this->modelAddress->getTable();

        $where = array(
            array('col_key', 'member'),
            array('member_id', $_GET['id'])
        );       
        /**
         * 清除全部默认值 
         */
        $tbl->updateField($where, 'default', 0);

        $where = array(
            'in()' => array('add_id' => $pkvs)
            );       

        $tbl->updateField($where, 'default', 1);

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
     * 删除地址信息
     */
    function actionRemoveAddr()
    {
        /**
         * 按主键删除单个等级
         */
        if ($_GET['add_id']) {
            $pkvs = array((int)$_GET['add_id']);
        }
        /**
         * 按主键删除多个等级
         */
        if ($_POST['check']) {
            $pkvs = $_POST['check'];
        }
        /**
         * 设置异常拦截点
         */
        __TRY();
        /**
         * 删除所选等级
         */
        $this->modelAddress->removeAll($pkvs);
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
     * 编辑地址视图 
     * 
     * @param mixed $data 
     * @access private
     * @return void
     */
    private function _editAddress(&$data)
    {
        /**
         * 获得会员资料
         */
        $data['members'] = $this->modelMember->getOne((int)$_GET['id']);

        if ($data['members']['addresses']) {
            foreach ($data['members']['addresses'] as $key => $value) {
                $data['members']['addresses'][$key]['address'] = unserialize($value['address']);
            }
        }
        /**
         * 设置当前视图为返回视图
         */
        $this->_setBack();
        /**
         * 输出编辑会员收货地址视图
         */
        $this->_executeView('modules/members/address.tpl', $data);

    }
    /**
     * Ajax 赠送优惠券
     */
    public function actionAjaxSendCoupon()
    {
        if ($_POST) {

            $modelCoupon =& FLEA::getSingleton("Model_Coupons");

            if ($modelCoupon->send(intval($_POST['cou_id']),intval($_POST['member_id']))) {

                $json_data = array(
                    'success' => 1
                );
                echo json_encode($json_data);
            }
        }
    }
    /**
     * Ajax选择区域数据
     *
     * @return
     */
    function actionAjaxSelectArea()
    {
        $prov_id = isset($_POST['prov_id']) ? (int)$_POST['prov_id'] : null;

        if ($prov_id) {

            $where = array(
                array('col_key', 'area'),
                array('lang', getLanguage()),
                array('parent_id', $prov_id)
            );

            $modelCategories =& FLEA::getSingleton("Model_Categories");
            
            $options = $modelCategories->getAll($where, 'sort_id ASC, created DESC', 'cate_id, parent_id, name');

            $html = '';
            foreach ($options as $key => $opt) {
                $html .= "<option ";
                 if ($_POST['current_id'] == $opt['cate_id']) { $html .= 'selected="selected"'; }               
                $html .= " value=\"{$opt['cate_id']}\">{$opt['name']}</option>";
            }
            echo $html;
        }
    }
}

