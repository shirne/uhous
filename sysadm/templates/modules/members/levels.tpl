{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='栏目管理' position='会员等级管理' footprint='yes' }}

{{ assign var='cmdType' value='level' }}

{{ include file='modules/members/cmd.tpl' }}

    <div class="layout clearfix">

        <div class="box">
            <h3>等级列表</h3>
            <form id="listform" name="listform" action="{{ url controller='Member' action='RemoveCategories' }}" method="post">
                <table class="table-data">
                    <thead>
                        <tr>
                            <th width="5%"><input id="checkall" name="checkall" type="checkbox" /></th>
                            <th width="45%">等级名称</th>
                            <th width="20%">创建日期</th>
                            <th>管理</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th colspan="4"><input class="ibtn" type="button" value="删除所选" onclick="remove_confirm('#listform', '')" /></th>
                        </tr>
                    </tfoot>
                    <tbody>
{{ foreach from=$levels item=level }}
                        <tr>
                            <td class="tc"><input id="check[]" name="check[]" type="checkbox" value="{{$level.level_id}}" /></td>
                            <td><a href="{{ url controller='Member' action='ModifyLevel' id=$level.level_id}}">{{$level.levels}}</a></td>
                            <td class="tc">{{$level.created|date_format:'%Y/%m/%d %H:%M:%S'}}</td>
                            <td class="tc">
                                {{if $level.level_id != 1}}
                                <a href="{{ url controller='Member' action='ModifyLevel' id=$level.level_id}}">编辑</a> | <a href="{{ url controller='Member' action='RemoveLevels' id=$level.level_id}}" onclick="remove_confirm('#listform', this); return(false);">删除</a>
                                {{/if}}
                            </td>
                        </tr>
{{ foreach from=$level.children item=child }}
                        <tr>
                            <td class="tc"><input id="check[]" name="check[]" type="checkbox" value="{{$child.level_id}}" /></td>
                            <td><a href="{{ url controller='Member' action='ModifyLevel' id=$child.level_id}}"> |- {{$child.levels}}</a></td>
                            <td class="tc">{{$child.created|date_format:'%Y/%m/%d %H:%M:%S'}}</td>
                            <td class="tc"><a href="{{ url controller='Member' action='ModifyLevel' id=$child.level_id}}">编辑</a> | <a href="{{ url controller='Member' action='RemoveLevels' id=$child.level_id}}" onclick="remove_confirm('#listform', this); return(false);">删除</a></td>
                        </tr>
{{ /foreach }}
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

