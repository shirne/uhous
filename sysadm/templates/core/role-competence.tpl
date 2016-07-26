{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='权限管理' position='角色管理' printfoot=false }}

    <div id="cmd">
        <a class="btn fl" href="{{ url controller='Admin' action='NewRole' }}">添加角色</a>
        <a class="btn fl" href="{{ url controller='Admin' action='Roles' }}">角色列表</a>
        <div class="clear"><!-- Clear Float --></div>
    </div>

    <div class="layout clearfix">

        <div class="box">
            <h3>[{{$role.label}}] 角色权限设置</h3>
            <div class="form">

                <form id="editform" name="editform" action="{{ url controller='Admin' action='SaveCompetence' }}" method="post">
{{ assign var='languagesWidth' value=100 }}
                    <table>
                        <tr>
{{ foreach from=$languages item=lang key=key }}
                            <td width="{{$languagesWidth/$languagesCount}}%" style="vertical-align: text-top">
                                <div class="colbox">
                                    <h4>{{$lang}}</h4>
                                    <ol>
{{ foreach from=$columns[$key] item=column }}
                                        <li class="colbox-top">{{ webcontrol type='Columncheckbox' name='col_id[]' value=$column.col_id checked=$role.columns }} {{$column.name}}
{{ if $column.childrens }}
                                            <ul>
{{ foreach from=$column.childrens item=child }}
                                                <li class="colbox-sub">{{ webcontrol type='Columncheckbox' name='col_id[]' value=$child.col_id checked=$role.columns }} {{$child.name}}</li>
{{ /foreach }}
                                            </ul>
{{ /if }}
                                        </li>
{{ foreachelse }}
                                        <p class="tc">暂无栏目</p>
{{ /foreach }}
                                    </ol>
                                </div>
                            </td>
{{ /foreach }}
                        </tr>
                        <tr>
                            <td colspan="{{$languagesCount}}">
                                <p>
                                    <input class="ibtn ibtn-ok" type="submit" value="保存设置" />
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

