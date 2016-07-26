{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='权限管理' position='角色管理' printfoot=false }}

    <div id="cmd">
        <a class="btn fl" href="{{ url controller='Admin' action='NewRole' }}">添加角色</a>
        <a class="btn fl btn-on" href="{{ url controller='Admin' action='Roles' }}">角色列表</a>
        <div class="clear"><!-- Clear Float --></div>
    </div>

    <div class="layout clearfix">

        <div class="box">
            <h3>角色列表</h3>
            <form id="listform" name="listform" action="{{ url controller='Admin' action='RemoveRole' }}" method="post">
                <table class="table-data">
                    <thead>
                        <tr>
                            <th width="5%"><input id="checkall" name="checkall" type="checkbox" /></th>
                            <th width="25%">角色名称</th>
                            <th width="25%">角色识别</th>
                            <th>管理</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th colspan="7"><input class="ibtn" type="button" value="删除所选" onclick="remove_confirm('#listform', '')" /></th>
                        </tr>
                    </tfoot>
                    <tbody>
{{ foreach from=$roles item=role }}
                        <tr>
                            <td class="tc">{{ if $role.role_id!= 1 }}<input id="check[]" name="check[]" type="checkbox" value="{{$role.role_id}}" />{{ else }}-{{ /if }}</td>
                            <td class="tc"><a href="{{ url controller='Admin' action='ModifyRole' id=$role.role_id }}">{{$role.label}}</a></td>
                            <td class="tc">{{$role.name}}</td>
                            <td class="tc"><a href="{{ url controller='Admin' action='ModifyRole' id=$role.role_id }}">编辑角色</a>{{ if $role.role_id != 1 }} | <a href="{{ url controller='Admin' action='Competence' id=$role.role_id }}">权限设置</a> | <a href="{{ url controller='Admin' action='RemoveRole' id=$role.role_id }}" onclick="remove_confirm('#listform', this); return(false);">删除{{ /if }}</a></td>
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

