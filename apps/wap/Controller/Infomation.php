<?php
/**
 * 单页模块
 */
class Controller_Infomation extends Controller_Base
{
	function __construct()
	{
		
	}
	
	function actionIndex()
	{
		$this->_executeView('info.xhtml');
	}
}
