<?php
return array(
    //发送方证书路径(商户证书)
    'keyfile'=>dirname(__FILE__)."/../cer/WF8_KAFAI.pem",
    
    //接收方证书路径(银联证书)
    'certfile'=>dirname(__FILE__)."/../cer/GNETE.cer",
    
    //支付结果接收URL，要根据自己的接收URL填写
    'callbackurl'=>'http://'.$_SERVER['SERVER_NAME'].url('check','unionpayfront'),
    
    //
    'password'=>'ABSDEFG55H'  #'123456'
);
