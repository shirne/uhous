<?php
/**
 * 访问控制配置文件
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Config
 * @category   File
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/

/**
 * 实例化访问控制模型
 */
$modelAct =& FLEA::getSingleton('Model_Act');

return $modelAct->getAct();

