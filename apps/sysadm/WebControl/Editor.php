<?php
/**
 * Fck编辑器控件
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    WebControl
 * @category   Function
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/

function _ctlEditor($name, $attribs)
{
    $opts = array('value', 'style', 'height');
    $data = FLEA_WebControls::extractAttribs($attribs, $opts);

    if(!$data['style']) { $data['style']='Default'; }
    if(!$data['height']) { $data['height']=350; }

    $sBasePath = '/libs/fckeditor/';
    include_once(FLEA::getAppInf('fckDir').DS.'fckeditor.php');
    $oFCKeditor = new FCKeditor($name);
    $oFCKeditor->BasePath   = $sBasePath;
    $oFCKeditor->Value      = $data['value'];
    $oFCKeditor->ToolbarSet = $data['style'];
    $oFCKeditor->Height     = $data['height'];
    $editor = $oFCKeditor->CreateHtml();
    return $editor;
}

