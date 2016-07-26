<?php
/**
 * 产品展示模块
 *
 * 
 */
class Controller_Products extends Controller_Base
{
	private $modelProduct;
	private $modelBrand;
	
	function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * 产品首页
	 * 显示所有分类
	 */
	function actionIndex()
	{
		$this->_executeView('products.xhtml');
	}
	
	/**
	 * 品牌首页
	 * 显示所有品牌
	 */
	function actionBrand()
	{
		$this->_executeView('brands.xhtml');
	}
	
	/**
	 * 产品列表页
	 * 根据所选分类或品牌分页显示产品列表
	 */
	function actionList()
	{
		$this->_executeView('products_list.xhtml');
	}
	
	/**
	 * 产品搜索
	 */
	function actionSearch()
	{
		
	}
	
	/**
	 * 产品详细页
	 */
	function actionView()
	{
		$this->_executeView('products_view.xhtml');
	}
	
	/**
	 * 评论页
	 */
	function actionComment()
	{
		$this->_executeView('products_comment.xhtml');
	}
}
