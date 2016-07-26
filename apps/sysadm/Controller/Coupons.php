<?php
/**
 * 优惠券管理模块
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Controller
 * @category   Class
 * @author     Jazyone <zhongjintang@gmail.com>
 * @version    $Id$
 **/

class Controller_Coupons extends Controller_Base
{
    /**
     * 优惠券模型对象 
     * 
     * @var mixed
     * @access private
     */
    private $modelCoupons = null;   

    function __construct()
    {
        parent::__construct();
        /**
         *  实例化优惠券管理模型
         */
        $this->modelCoupons =& FLEA::getSingleton('Model_Coupons');
    }

    /**
     * 优惠券列表 
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
        //分页查找优惠券列表数据
        // 
        /**
         * 条件 
         */
        $where = array(
            array('col_key', getColKey()),
            array('lang', getLanguage())
            );
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
        $tbl = $this->modelCoupons->getTable();
        /**
         * 载入分页助手 
         */
        FLEA::loadHelper('pager');
        /**
         * 实例化一个分页助手，并将所需数据读取出来存于$data数组中 
         */
        $pager = new FLEA_Helper_Pager($tbl, $page, $pagesize, $where, $sortby);
        $data['pager'] = $pager->getPagerData();
        $data['coupons'] = $pager->findAll('*');

        /**
         * Pagenav 链接构造参数
         */
        $data['controller'] = 'Coupons';
        $data['action'] = 'Index';
        $data['colkey'] = getColkey();
        $data['lang'] = getLanguage();

        $tpl->assign($data);
        $tpl->display('modules/coupons/list.tpl');
    }
    /**
     * 添加优惠券 
     * 
     * @access public
     * @return void
     */
    function actionAddNew()
    {
        $this->_editCoupons();
    }
    /**
     * 编辑优惠券 
     * 
     * @access public
     * @return void
     */
    function actionModify($pkv = null)
    {
        if ($_GET['id']) {
            $pkv = $_GET['id'];
        }
        
        $tbl = $this->modelCoupons->getTable();
        $data['coupon'] = $tbl->find(array(array('cou_id', $pkv)), null, '*', false);

        $this->_editCoupons($data);
    }
    /**
     * 保存优惠券 
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
        $row = $_POST;

        date_default_timezone_set('Asia/Chongqing');
        list($year, $month, $day) = explode('-', $row['period']);
        $row['period'] = mktime(0,0,0,$month,$day,$year);
        /**
         * 保存优惠券
         */
        $this->modelCoupons->save($row);
        /**
         * 获取抛出的异常
         */
        $ex = __CATCH();
        /**
         * 判断是否是一个异常
         */
        if (__IS_EXCEPTION($ex)) {
            
            js_alert($ex->getMessage(), 0, $this->_getBack());
        }else{
            
            //更新已赠送的优惠券信息
            $coupons=$this->modelCoupons->getOne($row['cou_id']);
            $memberCoupon=&FLEA::getSingleton('Table_Membercoupon');
            $invaluetime=0;
            
            if($coupons['invaluetype']==1){
                $invaluetime=' `created` + '.$coupons['exprise'];
            }else{
                $invaluetime=$coupons['period'];
            }
            
            foreach($coupons['memberCoupon'] as $row){
                $ids[]=$row['id'];
            }
            
            if(!empty($ids)){
                $memberCoupon->execute('UPDATE `'.$memberCoupon->fullTableName.'` SET `invaluetime`='.$invaluetime.' WHERE id IN('.implode(', ',$ids).')');
            }
            
        }
        /**
         * 返回页面 
         */
        return $this->actionIndex();
    }
    /**
     * 删除优惠券 
     * 
     * @access public
     * @return void
     */
    function actionRemove()
    {
        /**
         * 按主键删除单个优惠券
         */
        if ($_GET['id']) {
            $pkvs = array((int)$_GET['id']);
        }
        /**
         * 按主键删除多个优惠券
         */
        if ($_POST['check']) {
            $pkvs = $_POST['check'];
        }
        /**
         * 设置异常拦截点
         */
        __TRY();
        /**
         * 删除所选优惠券
         */
        $this->modelCoupons->removeAll($pkvs);
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
        return $this->actionIndex();
    }
    /**
     * 删除优惠券图片 
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
         * 删除所选优惠券
         */
        $this->modelCoupons->removePic($pkvs);
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

        return $this->actionModify($pkvs);
    }
    /**
     * 编辑优惠券信息 
     * 
     * @param mixed $pkv 
     * @access protected
     * @return void
     */
    function _editCoupons($data = null)
    {
        $tpl =& $this->_getView();

        $data['col_key'] = getColKey();
        $data['lang'] = getLanguage();
        
        $tpl->assign($data);
        $tpl->display('modules/coupons/modify-coupons.tpl');
    }
    /**
     * 优惠券排序视图 
     * 
     * @access public
     * @return void
     */
    function actionSort()
    {
        $tpl =& $this->_getView();

        $advs = $this->modelCoupons->getTable();

        $where = array(
            array('col_key', getColKey()),
            array('lang', getLanguage())
            );

        $data['coupons'] = $advs->findAll($where, 'sort_id ASC, created DESC', null, 'cou_id, name', false);

        $this->_setBack();

        $tpl->assign($data);

        $tpl->display('modules/coupons/sort-coupons.tpl');
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
        $this->modelCoupons->saveSort($_POST['seqNoList']);
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
