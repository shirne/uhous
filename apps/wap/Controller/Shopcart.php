<?php
/**
 * 购物车模块
 * 
 * 
 */
class Controller_Shopcart extends Controller_Base
{
	private $modelUser;
	private $modelOrder;
	
	function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * 查看购物车
	 */
	function actionIndex()
	{
		$this->_executeView('shopping_cart.xhtml');
	}
	
	/**
	 * 添加到购物车
	 */
	function actionAdd()
	{
		
	}
	
	/**
	 * 删除物品
	 */
	function actionDel()
	{
		
	}
	
	/**
	 * 清空购物车
	 */
	function actionClear()
	{
		
	}
	
	/**
	 * 生成订单
	 */
	function actionOrder()
	{
		
	}
	
	/**
	 * 付款
	 */
	function actionPay()
	{
		
	}
	
}

