<?php
/*
 * 主页模块
 *
 */
class Controller_Home extends Controller_Base
{
	private $modelProduct;
	private $modelAdvance;
	
	function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * 首页
	 */
	function actionIndex()
	{
		$data['test']='测试数据';
		$this->_executeView('index.xhtml',$data);
	}
	
	/**
	 * 错误页
	 */
	function actionError()
	{
		$data=array();
		$this->_executeView('tips.xhtml',$data);
	}
}
