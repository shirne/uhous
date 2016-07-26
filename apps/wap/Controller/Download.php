<?php
/*
 * 下载模块.保留为以后的客户端下载
 *
 */
class Controller_Download extends Controller_Base
{
	function __construct()
	{
		parent::__construct();
	}
	
	function actionIndex()
	{
		$this->_executeView('downloads.xhtml');
	}
	
	function actionDownload()
	{
		
	}
}
