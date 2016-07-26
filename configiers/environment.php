<?php

/**
 * 环境配置文件
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Config
 * @category   File
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/
return array (
	// 应用相关
	'appName' => 'SixHorses在线营销系统',
	'appVersion' => '0.2.0',
	'customer' => '中山市车水马龙电子商务有限公司',

	// URI相关
	'urlLowerChar' => true,
	'urlAlwaysUseAccessor' => false,
	//'urlAlwaysUseBootstrap' => false,

	// 定义目录
	'internalCacheDir' => str_replace('/', DS, ROOT_DIR . '/cache/runtime'),
	'logFileDir' => str_replace('/', DS, ROOT_DIR . '/cache/log'),
	'webControlsExtendsDir' => array (
		str_replace('/', DS, ROOT_DIR . '/apps/common/WebControl'),
		str_replace('/', DS, ROOT_DIR . '/apps/' . $this->_app . '/WebControl')
	),
	'uploadDir' => 'uploads/',
	'uploadPath' => str_replace('/', DS, ROOT_DIR . '/uploads/'),

	// 日志相关
	'logFilename' => $this->_app . '_access.log',

	// 语言相关
	'languageFilesDir' => str_replace('/', DS, ROOT_DIR . "/{$this->_app}/Languages"),
	'responseCharset' => 'utf-8',
	'languages' => array (
		'zh-cn' => '简体中文'
	),
	'defaultLanguage' => 'zh-cn',

	// 自动加载
	'autoLoad' => array (
		'FLEA_Controller_Action',
		'FLEA_Helper_Array',
		'Controller_Base',
		'Helper_Common',
		'Helper_Merger'
	),

	// 视图相关
	'view' => 'Helper_Smarty',
	'viewConfig' => array (
		'smartyDir' => str_replace('/', DS, ROOT_DIR . '/libs/Smarty'),
		'compile_dir' => str_replace('/', DS, ROOT_DIR . '/cache/tmp'),
		'left_delimiter' => '{{',
		'right_delimiter' => '}}'
	)
);