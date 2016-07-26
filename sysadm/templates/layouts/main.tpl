{{ include file='layouts/head.tpl' }}

    <!--// Header On North Panel -->
    <div id="header">
        <div id="user-panel">
            <p>你好, {{$admin.username}} <a href="{{ url controller='Admin' action='Profile' }}" target="inner-content">修改密码</a> | <a href="{{ url controller='Admin' action='Logout' }}">退出系统</a></p>
            <a class="btn" href="/" title="查看网站">查看网站</a>
            <div class="clear"><!-- Clear Float --></div>
        </div>
        <h1 id="logo"><a class="pngicon" href="{{ url controller='Dashboard' }}" title="返回控制台">Six Horses</a></h1>
        <div class="clear"><!-- Clear Float --></div>
    </div>

{{ webcontrol type='Sidebar' name='sidebar' }}

    <!--// Content On Center Panel -->
    <div id="content">
        <iframe id="inner-content" name="inner-content" src="{{ url controller='Dashboard' action='Welcome' }}"></iframe>
    </div>

    <!--// Footer On South Panel -->
    <div id="footer" class="clearfix">

        <div id="languages">
            {{ webcontrol type='Languages' name=$language }}
        </div>

        <div id="quicklink">
            <label>快速通道:</label>
            <div>
                <ul>
                    <li><a class="btn" href="{{ url controller='Settings' }}" title="网站设置" target="inner-content">网站设置</a></li>
                    <li><a class="btn" href="{{ url controller='Settings' action='ClearCache' }}" title="清空缓存" target="inner-content">清空缓存</a></li>
                </ul>
            </div>
        </div>

    </div>

</body>

</html>

