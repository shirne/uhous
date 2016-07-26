<?php

/*
 * Created on 2012-3-13
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class Controller_Member extends Controller_Base {
	private $modelMember;
	private $modelOrder;

	function __construct() {
		parent :: __construct();
	}

	/**
	 * 会员中心
	 */
	function actionIndex() {
		$this->_executeView('member.xhtml');
	}

	/**
	 * 会员登陆
	 */
	function actionLoin() {
		$this->_executeView('login.xhtml');
	}

	/**
	 * 登陆处理
	 */
	function actionDoLogin() {

	}

	/**
	 * 会员注册
	 */
	function actionReg() {
		$this->_executeView('reg.xhtml');
	}

	/**
	 * 注册处理
	 */
	function actionDoReg() {

	}
	
	/**
	 * 资料修改
	 */
	function actionModify()
	{
		$this->_executeView('member_mod.xhtml');
	}
	
	/**
	 * 资料修改处理
	 */
	function actionDoModify()
	{
		
	}
	
	/**
	 * 订单列表
	 */
	function actionOrderList()
	{
		$this->_executeView('member_order.xhtml');
	}
	
	/**
	 * 错误处理
	 */
	function _error($msg = null, $title = null, $url = null) {
		
		if(!$msg)$msg='您尚未登陆或登陆超时,请重新登陆!';
		if(!$title)$title='错误';
		if(!$url)$url=url('Member','Login');
		
		parent::_error($msg, $title, $url);
	}

}
