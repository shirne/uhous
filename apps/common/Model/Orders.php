<?php
/**
 * 订单管理模型
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Model
 * @category   Class
 * @author     Jazyone <zhongjintang@gmail.com>
 * @version    $Id$
 **/

//{{ 载入类
FLEA::loadClass('Model_Abstract');
//}}

class Model_Orders extends Model_Abstract
{
    function __construct()
    {
        parent::__construct('Table_Orders');
    }

    function save(&$row)
    {
        /**
         * 未定义语言版本
         */
        if (!$row['lang']) {
            //{{ 载入异常处理类
            FLEA::loadClass('Exception_Undefined');
            //}}
            // 抛出异常
            __THROW(new Exception_Undefined('语言版本'));
            return;
        }

        $row['delivery_way'] = serialize($row['delivery_way']);

        if (parent::save(&$row)) {
            return true;
        }

        //{{ 载入异常处理类
        FLEA::loadClass('Exception_Failed');
        //}}
        // 抛出异常
        __THROW(new Exception_Failed('保存订单失败'));
        return;
    }
    
    //取消订单，同时将未付款的订单使用的优惠券取消
    function cancel($id){
    	$where[]=array(
    		'order_id',
    		$id
    	);
    	$where[]=array(
    		'state',
    		0
    	);
    	$row=$this->tbl->find($where,null,'*',false);
    	if(empty($row)){
    		return false;
    	}
    	
    	if($this->tbl->updateField($where,'state',7)){
    		if(!empty($row['coupon_id'])){
    			$mcou=& FLEA::getSingleton('Table_Membercoupon');
    			$mcou->updateField(array(array('id',$row['coupon_id'])),'status',0);
    		}
    		return true;
    	}else{
    		return false;
    	}
    }
    
    /**
     * 删除订单
     *
     * @param array $pkvs 
     * @access public
     * @return 成功返回 true
     */
    function removeAll($pkvs)
    {
        /**
         * 删除订单
         */
        if (!$this->tbl->removeByPkvs($pkvs)) {
            //{{ 载入异常处理类
            FLEA::loadClass('Exception_Failed');
            //}}
            // 抛出异常
            __THROW(new Exception_Failed('无法删除所选订单'));
            return;
        } else {
            return true;
        }
    }
}
