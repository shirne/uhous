<?php
/**
 * 访问控制配置文件
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @package    Config
 * @category   File
 * @author     Allen <movoin@gmail.com>
 * @version    $Id: acl.php 10 2010-04-02 02:24:22Z allen $
 **/

return array(

    'allow' => RBAC_EVERYONE,
    'Member' => array(
        'allow' => RBAC_EVERYONE,
    ),
    'Home' => array(
        'allow' => RBAC_EVERYONE    
    ),
    'Products' => array(
        'allow' => RBAC_EVERYONE    
    ),
    'Information' => array(
        'allow' => RBAC_EVERYONE    
    ),
    'Exchange' => array(
        'allow' => RBAC_EVERYONE    
    ),
    'Guestbook' => array(
        'allow' => RBAC_EVERYONE    
    ),
    'Ajax' => array(
        'allow' => RBAC_EVERYONE    
    ),
    'Check' => array(
        'allow' => RBAC_EVERYONE    
    ),
    'Designer' => array(
        'allow' => RBAC_EVERYONE    
    )
);
