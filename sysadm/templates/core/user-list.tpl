{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='权限管理' position='管理员管理' printfoot=false }}

    <div id="cmd">
        <a class="btn fl" href="{{ url controller='Admin' action='NewUser' }}">添加管理员</a>
        <a class="btn fl btn-on" href="{{ url controller='Admin' action='Users' }}">管理员列表</a>
        <div class="clear"><!-- Clear Float --></div>
    </div>

    <div class="layout clearfix">

        <div class="box">
            <h3>管理员列表</h3>
            <form id="listform" name="listform" action="{{ url controller='Admin' action='Remove' }}" method="post">
                <table class="table-data">
                    <thead>
                        <tr>
                            <th width="5%"><input id="checkall" name="checkall" type="checkbox" /></th>
                            <th width="15%">登录名</th>
                            <th width="15%">角色</th>
                            <th width="15%">上次登录日期</th>
                            <th width="20%">上次登录IP</th>
                            <th width="10%">登录次数</th>
                            <th>管理</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th colspan="7"><input class="ibtn" type="button" value="删除所选" onclick="remove_confirm('#listform', '')" /></th>
                        </tr>
                    </tfoot>
                    <tbody>
{{ foreach from=$users item=user }}
                        <tr>
                            <td class="tc">{{ if $user.admin_id != 1 }}<input id="check[]" name="check[]" type="checkbox" value="{{$user.admin_id}}" />{{ else }}-{{ /if }}</td>
                            <td class="tc"><a href="{{ url controller='Admin' action='ModifyUser' id=$user.admin_id }}">{{$user.username}}</a></td>
                            <td class="tc">{{ foreach from=$user.roles item=role }}<a href="{{ url controller='Admin' action='ModifyRole' id=$role.role_id }}">{{$role.label}}</a>{{ /foreach }}</td>
                            <td class="tc">{{$user.last_login|date_format:'%Y/%m/%d %H:%M:%S'}}</td>
                            <td class="tc">{{$user.last_login_ip}}</td>
                            <td class="tc">{{$user.login_count}}</td>
                            <td class="tc"><a href="{{ url controller='Admin' action='ModifyUser' id=$user.admin_id }}">编辑</a>{{ if $user.admin_id != 1 }} | <a href="{{ url controller='Admin' action='Remove' id=$user.admin_id }}" onclick="remove_confirm('#listform', this); return(false);">删除{{ /if }}</a></td>
                        </tr>
{{ /foreach }}
                    </tbody>
                </table>
            </form>
        </div>

        <div class="clear"><!-- Clear Float --></div>

    </div>

</div>

</body>

</html>

