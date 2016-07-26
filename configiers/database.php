<?php
/**
 * 数据库配置文件
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Config
 * @category   File
 * @author     Allen <movoin@gmail.com>
 * @version    $Id$
 **/
return array (
    'dbDSN' => array(
      'driver' => 'mysql',
      'host' => 'localhost',
      'login' => 'root',	#'gain_2011',
      'password' => '123456',		#'$#125afFAGRaf',
      'database' => 'gain',
      'port' => 3306,
      'charset' => 'utf8'
    ),
    'dbTablePrefix' => 'eoms_'
);

