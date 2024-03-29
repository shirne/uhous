<?php
/////////////////////////////////////////////////////////////////////////////
// FleaPHP Framework
//
// Copyright (c) 2005 - 2008 QeeYuan China Inc. (http://www.qeeyuan.com)
//
// 许可协议，请查看源代码中附带的 LICENSE.txt 文件，
// 或者访问 http://www.fleaphp.org/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
 * 定义 FLEA_View_Exception_InitSmartyFailed 类
 *
 * @copyright Copyright (c) 2005 - 2008 QeeYuan China Inc. (http://www.qeeyuan.com)
 * @author 起源科技 (www.qeeyuan.com)
 * @package Exception
 * @version $Id: InitSmartyFailed.php 2 2010-04-27 16:47:43Z allen $
 */

/**
 * FLEA_View_Exception_InitSmartyFailed 指示 FLEA_View_Smarty 无法初始化 Smarty 模版引擎
 *
 * @package Exception
 * @author 起源科技 (www.qeeyuan.com)
 * @version 1.0
 */
class FLEA_View_Exception_InitSmartyFailed extends FLEA_Exception
{
    var $filename;

    function FLEA_View_Exception_InitSmartyFailed($filename)
    {
        $this->filename = $filename;
        $code = 0x0902002;
        parent::FLEA_Exception(sprintf(_ET($code), $filename), $code);
    }
}
