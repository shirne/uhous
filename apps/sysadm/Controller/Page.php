<?php
/**
 * 后台单页控制器
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Controller
 * @category   Class
 * @author     Jazyone <zhongjintang@gmail.com>
 * @version    $Id$
 **/

//{{ 载入类
FLEA::loadClass('Controller_Base');
//}}

class Controller_Page extends Controller_Base
{
    function __construct()
    {
        parent::__construct();
    }

    function actionIndex()
    {
        $tpl =& $this->_getView();
        $tpl->display('back/Single/Editor.tpl');
    }

    function actionEdit()
    {
        $tpl =& $this->_getView();
        $tpl->display('modules/single/Editor.tpl');
    }
}
