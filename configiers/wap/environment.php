<?php
/*
 * Created on 2012-3-13
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
return array (
    // 控制器相关
    'defaultController' => 'Home',
    'controllerAccessor' => 'column',
    'actionAccessor' => 'do',

    // 访问控制相关
    'RBACSessionKey' => 'SIXHORSES.WAP.SESSIONKEY',
    'dispatcher' => 'FLEA_Dispatcher_Auth',
    'autoQueryDefaultACTFile' => true,
    'defaultControllerACTFile' => ROOT_DIR . '/configiers/wap/acl.php',
    'autoSessionStart'  => true,
    'dispatcherAuthFailedCallback' => 'callbackHandle',
    
    //WAP页面,不使用自动输出头信息
    'autoResponseHeader' => false,

    'templatesDir' => str_replace('/', DS, ROOT_DIR . '/wap'),

    // 视图相关
    'viewConfig' => array(
        'template_dir' => str_replace('/', DS, ROOT_DIR . '/wap/templates'),
    )
);
