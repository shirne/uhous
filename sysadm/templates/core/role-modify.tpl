{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='权限管理' position='角色管理' printfoot=false }}

    <div id="cmd">
        <a class="btn fl{{ if !$role.role_id }} btn-on{{ /if }}" href="{{ url controller='Admin' action='NewRole' }}">添加角色</a>
        <a class="btn fl" href="{{ url controller='Admin' action='Roles' }}">角色列表</a>
        <div class="clear"><!-- Clear Float --></div>
    </div>

    <div class="layout clearfix">

        <div class="box">
            <h3>{{ if $role.role_id }}修改{{ else }}添加{{ /if }}角色</h3>
            <div class="form">

                <div></div>

                <form id="editform" name="editform" action="{{ url controller='Admin' action='SaveRole' }}" method="post">
                    <table>
                        <tr>
                            <td width="50%">
                                <p>
                                    <label for="label">角色名称:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="label" name="label" value="{{$role.label}}" /></b></b>
                                    <small>请输入只10个汉字以内的名称。</small>
                                </p>
                            </td>
                            <td width="20"></td>
                            <td>
                                <p>
                                    <label for="name">角色识别:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="name" name="name" value="{{$role.name}}" readonly="readonly" /></b></b>
                                    <small>系统自动分配，无须修改。</small>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <p>
                                    <fieldset class="fold">
                                        <legend>应用此角色的管理员</legend>
                                        <div>
                                            <ul class="inline-list clearfix">
{{ foreach from=$users item=user }}
                                                <li><a href="{{ url controller='Admin' action='ModifyUser' id=$user.admin_id }}">{{$user.username}}</a></li>
{{ /foreach }}
                                            </ul>
                                        </div>
                                    </fieldset>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <p>
                                    <input class="ibtn ibtn-ok" type="submit" value="保存" />
                                    <input id="role_id" name="role_id" type="hidden" value="{{$role.role_id}}" />
                                </p>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>

        <div class="clear"><!-- Clear Float --></div>

    </div>

</div>

</body>

</html>

