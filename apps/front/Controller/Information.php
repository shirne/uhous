<?php
/**
 * 信息模型
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Controller
 * @category   Class
 * @author     Jazyone <zhongjintang@gmail.com>
 * @version    $Id$
 **/

class Controller_Information extends Controller_Base
{
    /**
     * 页面信息索引id 
     */
    private $pageIds = array(
        'about' => 16,          // 关于我们
        'guide' => 6,           // 购买流程
        'question' => 7,        // 购买流程
        'delivery' => 4,        // 配送方式
        'deliveryTime' => 3,    // 配送时间及费用
        'weixiu' => 12,         // 维修补件说明
        'tuihuo' => 11,         // 退货办理流程
        'definition' => 13,     // 免责声明
        'register' => 14,       // 注册协议
        'serect' => 15,         // 隐私保护
        'onlinePay' => 17,      // 银行在线支付方式
        'platformPay' => 18,    // 支付平台方式
        'counterPay' => 19,     // 银行柜台方式
    );
    /**
     * 单页模型 
     * 
     * @var mixed
     * @access private
     */
    private $modelInfo;
    /**
     * 构造函数 
     * 
     * @access protected
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        /**
         * 实例化单页模型 
         */
        $this->modelInfo =& FLEA::getSingleton('Model_Information');
    }
    /**
     * 关于我们 
     * 
     * @access public
     * @return void
     */
    public function actionAbout()
    {
        $data['page_id'] = $this->pageIds['about'];
        $data['title'] = '关于我们';
        $data['about'] = 1;
        $this->_getPage($data);
    }
    /**
     * 购买流程 
     * 
     * @access public
     * @return void
     */
    public function actionGuide()
    {
        $data = $this->_MegerTwoPage($this->pageIds['guide'], $this->pageIds['question']);
        $data['title'] = '购物指南';
        $this->_executeView('page.html', $data);
    }
    /**
     * 配送办法 
     * 
     * @access public
     * @return void
     */
    public function actionDelivery()
    {
        $data = $this->_MegerTwoPage($this->pageIds['delivery'], $this->pageIds['deliveryTime']);
        $data['title'] = '配送方式';
        $this->_executeView('page.html', $data);
    }
    /**
     * 客户互动 
     * 
     * @access public
     * @return void
     */
    public function actionService()
    {
        $data = $this->_MegerTwoPage($this->pageIds['tuihuo'], $this->pageIds['weixiu']);
        $data['title'] = '售后服务';
        $this->_executeView('page.html', $data);
    }
    /**
     * 购物条款 
     * 
     * @access public
     * @return void
     */
    public function actionProvision()
    {
        $fore = $this->modelInfo->getPageById($this->pageIds['definition']);
        $back = $this->_MegerTwoPage($this->pageIds['serect'], $this->pageIds['register']);

        $data['page']['pic'] = (!empty($fore['pic'])&&($fore['updated'] > $back['page']['updated'])) ? $fore['pic'] : $back['page']['pic'];
        if (empty($back['page']['pic'])) { $data['page']['pic'] = $fore['pic']; }
        $data['page']['content'] = $fore['content'] . $back['page']['content'];

        $data['title'] = '购物条款';

        $this->_executeView('page.html', $data);
    }
    /**
     * 支付方式 
     * 
     * @access public
     * @return void
     */
    public function actionPayment()
    {
        $fore = $this->modelInfo->getPageById($this->pageIds['onlinePay']);
        $back = $this->_MegerTwoPage($this->pageIds['platformPay'], $this->pageIds['counterPay']);

        $data['page']['pic'] = (!empty($fore['pic'])&&($fore['updated'] > $back['page']['updated'])) ? $fore['pic'] : $back['page']['pic'];
        if (empty($back['page']['pic'])) { $data['page']['pic'] = $fore['pic']; }
        $data['page']['content'] = $fore['content'] . $back['page']['content'];

        $data['title'] = '付款方式';

        $this->_executeView('page.html', $data);
    }
    /**
     * 合并两个页面信息，并显示 
     * 
     * @param mixed $forePageId 
     * @param mixed $backPageId 
     * @access private
     * @return void
     */
    private function _MegerTwoPage($forePageId, $backPageId)
    {
        $fore = $this->modelInfo->getPageById($forePageId);
        $back = $this->modelInfo->getPageById($backPageId);
        $data['page']['pic'] = (!empty($fore['pic'])&&($fore['updated'] > $back['updated'])) ? $fore['pic'] : $back['pic'];
        $data['page']['updated'] = ($fore['updated'] > $back['updated']) ? $fore['updated'] : $back['updated'];
        if (empty($back['pic'])) { 
            $data['page']['pic'] = $fore['pic']; 
            $data['page']['updated'] = $fore['updated']; 
        }
        $data['page']['content'] = $fore['content'] . $back['content'];
        unset($fore);
        unset($back);
        return $data;
    }
    /**
     * 获取页面信息工具 
     * 
     * @param mixed $page_id 
     * @access private
     * @return void
     */
    private function _getPage(&$data)
    {
        $data['page'] = $this->modelInfo->getPageById($data['page_id']);

        $this->_setBack();
        $this->_executeView('page.html', $data);
    }
}
