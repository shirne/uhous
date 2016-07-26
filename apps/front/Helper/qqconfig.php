<?php
/**
 * QQ
 * shirne
 */
return array(
    'appid'=>100239300,
    'appkey'=>"16bf074a323a4d0dc9e6905f9346c8ec",
    'callback'=>"http://{$_SERVER['SERVER_NAME']}".url('member','QQCallback'),
    'scope'=>"get_user_info"
);
