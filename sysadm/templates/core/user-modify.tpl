{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='权限管理' position='管理员管理' printfoot=false }}

    <div id="cmd">
        <a class="btn fl{{ if !$user.admin_id }} btn-on{{ /if }}" href="{{ url controller='Admin' action='NewUser' }}">添加管理员</a>
        <a class="btn fl" href="{{ url controller='Admin' action='Users' }}">管理员列表</a>
        <div class="clear"><!-- Clear Float --></div>
    </div>

    <div class="layout clearfix">

        <div class="box">
            <h3>{{ if $user.admin_id }}修改{{ else }}添加{{ /if }}管理员</h3>
            <div class="form">

                <div></div>

                <form id="editform" name="editform" action="{{ url controller='Admin' action='SaveProfile' }}" method="post">
                    <table>
                        <tr>
                            <td colspan="3">
                                <p>
                                    <label for="roles">管理角色:</label>
{{ if $user.admin_id == 1 }}
    {{ assign var='disabled' value=true }}
{{ else }}
    {{ assign var='disabled' value=false }}
{{ /if }}
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='DropdownList' name='roles' items=$roles selected=$user.roles.0.role_id disabled=$disabled }}</b></b>
{{ if $disabled }}
                                    <input id="roles" name="roles" type="hidden" value="{{$user.roles.0.role_id}}" />
                                    <small>默认管理员的管理角色无法修改。</small>
{{ /if }}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="username">登录名称:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="username" name="username" value="{{$user.username}}" /></b></b>
                                </p>
                            </td>
                            <td width="20"></td>
                            <td>
                                <p>
                                    <label for="password">登录密码:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="password" id="password" name="password" value="" /></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <p>
                                    <input class="ibtn ibtn-ok" type="submit" value="保存" />
                                    <input id="admin_id" name="admin_id" type="hidden" value="{{$user.admin_id}}" />
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

