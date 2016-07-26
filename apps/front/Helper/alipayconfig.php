<?php
//支付宝配置
return array(

    //合作身份者id，以2088开头的16位纯数字
    'partner'=>'2088701361671617',
    
    //安全检验码，以数字和字母组成的32位字符
    'key'=>'z7qq2rq94vqo0man5coc5g0414l0dhi3',
    
    //签约支付宝账号或卖家支付宝帐户
    'seller_email'=>'better.lin@163.com',
    
    //页面跳转同步通知页面路径，要用 http://格式的完整路径，不允许加?id=123这类自定义参数
    'return_url'=>'http://'.$_SERVER['SERVER_NAME'].url('check','alipayfront'),
    #'http://www.uhous.com/apps/common/alipay/return_url.php',
    
    //服务器异步通知页面路径，要用 http://格式的完整路径，不允许加?id=123这类自定义参数
    'notify_url'=>'http://'.$_SERVER['SERVER_NAME'].url('check','alipayback'),
    #'http://www.uhous.com/apps/common/alipay/notify_urlIDK5412777.php',
    
    //签名方式 不需修改
    'sign_type'=>'MD5',
    
    //字符编码格式 目前支持 gbk 或 utf-8
    'input_charset'=>'utf-8',
    
    //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
    'transport'=> 'http'
);
