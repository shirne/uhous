{{ include file='layouts/head.tpl' }}

<div class="inner-content">

    <div id="welcome">
        <h2>Welcome, {{$admin.username}}!</h2>
    </div>

    <div class="layout clearfix">

        <div class="box mt">
            <h3>系统信息</h3>
            <div class="note">
                <table>
                    <tr>
                        <th width="15%">主机名称</th>
                        <td width="35%">{{ $sys.serverName }}</td>
                        <th width="15%">PHP运行方式</th>
                        <td width="35%">{{ $sys.phpRunType }}</td>
                    </tr>
                    <tr>
                        <th>服务器域名/IP地址</th>
                        <td>{{ $sys.serverHost }}</td>
                        <th>PHP版本</th>
                        <td>{{ $sys.phpVersion }}</td>
                    </tr>
                    <tr>
                        <th>服务器操作系统</th>
                        <td>{{ $sys.serverOS }}</td>
                        <th>运行于安全模式</th>
                        <td>{{ $sys.phpSafeMode }}</td>
                    </tr>
                    <tr>
                        <th>服务器解译引擎</th>
                        <td>{{ $sys.serverSoftwave }}</td>
                        <th>支持ZEND编译运行</th>
                        <td>{{ $sys.phpZend }}</td>
                    </tr>
                    <tr>
                        <th>服务器端口</th>
                        <td>{{ $sys.serverPort }}</td>
                        <th>程序最长运行时间</th>
                        <td>{{ $sys.phpExecTime }}秒</td>
                    </tr>
                    <tr>
                        <th>服务器时间</th>
                        <td>{{ $sys.serverTime }}</td>
                        <th>允许最大上传文件</th>
                        <td>{{ $sys.phpMaxUpload }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="box mt">
            <h3>版权信息</h3>
            <div class="note">
            </div>
        </div>

        <div class="clear"><!-- Clear Float --></div>

    </div>

</div>

</body>

</html>

