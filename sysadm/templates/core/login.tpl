<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{{ get_app_inf key='appName' }} v{{ get_app_inf key='appVersion' }}</title>

{{ load_css label='system-login' files='global, layout, login' version='20100424' }}

<!--[if IE]>
{{ load_css label='sysadm-ie' files='ie' version='20100424' }}
<![endif]-->

</head>

<body>
<div id="login-wrap">
    <div class="login-title"><h1>{{ get_app_inf key='appName' }}<small>授权予 {{ get_app_inf key='customer' }} 使用.</small></h1></div>
    <div class="login-form">
        <form method="post" action="{{ url controller='Admin' action='Login' }}">
            <p class="tline">Username: <input class="ltext" type="text" id="username" name="username" /></p>
            <p class="fline">Password: <input class="ltext" type="password" id="password" name="password" /> <img src="{{ url controller='Admin' action='ImgCode' t=$smarty.now }}" align="absmiddle" /> <input class="imgcode" type="text" id="imgcode" name="imgcode" /> <input class="lsubmit" type="submit" value="LOGIN" /></p>
        </form>
    </div>
    <div class="login-copyright">Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. All Rights Reserved.</div>
</div>
</body>
</html>

