
<!--// Sidebar On West Panel -->
<div id="{{$id}}">
    <div class="sidebar">

        <!-- 系统栏目 -->
        <h3><a href="#columns">栏目管理</a></h3>
        <div>
            <div class="sub-nav">
            {{ if $columns }}

            {{ foreach from=$columns item=column }}

                <h3><a href="#{{$column.col_key}}">{{$column.name}}</a></h3>
                <div>

                {{ if $column.childrens }}

                    <ul>

                {{ foreach from=$column.childrens item=child }}

                        <li><a href="{{ url controller=$child.controller action=$child.action colkey=$child.col_key }}{{$child.args}}" target="inner-content">{{$child.name}}</a></li>

                {{ /foreach }}

                    </ul>

                {{ /if }}

                </div>

            {{ /foreach }}

            {{ /if }}

            </div>
        </div>

        <!-- 权限设置 -->
        <h3><a href="#permissions">权限管理</a></h3>
        <div>
            <div class="nav">
                <ul>
{{ if $isadmin == 'yes' }}
                    <li>
                        <a href="{{ url controller='Admin' action='Users' }}" target="inner-content">管理员管理</a>
                    </li>
                    <li>
                        <a href="{{ url controller='Admin' action='Roles' }}" target="inner-content">角色管理</a>
                    </li>
{{ /if }}
                    <li>
                        <a href="{{ url controller='Admin' action='Profile' }}" target="inner-content">修改密码</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- 功能栏目 -->
        <h3><a href="#system">商城设置</a></h3>
        <div>
            <div class="nav">
                <ul>
                    <li>
                        <a href="{{ url controller='Settings' }}" target="inner-content">网站设置</a>
                    </li>
                    <li>
                        <a href="{{ url controller='Settings' action='alipay' }}" target="inner-content">支付宝参数设置</a>
                    </li>
                    <li>
                        <a href="{{ url controller='Settings' action='ClearCache' }}" target="inner-content">清空缓存</a>
                    </li>
{{ if $isadmin == 'yes' }}
                    <li>
                        <a href="{{ url controller='Columns' }}" target="inner-content">栏目设置</a>
                    </li>
{{ /if }}
                </ul>
            </div>
        </div>

    </div>
</div>

