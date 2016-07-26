{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='栏目管理' position='地区列表' footprint='yes' }}

{{ assign var='cmdType' value='area' }}

{{ include file='modules/setup/cate-cmd.tpl' }}

    <div class="layout clearfix">

        <div class="box">
            <h3>地区列表</h3>
            <form id="listform" name="listform" action="{{ url controller='Products' action='RemoveCategories' }}" method="post">
                <table class="table-data">
                    <thead>
                        <tr>
                            <th width="5%"><input id="checkall" name="checkall" type="checkbox" /></th>
                            <th width="45%">地区名称</th>
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
{{ foreach from=$categories item=category }}
                        <tr>
                            <td class="tc"><input id="check[]" name="check[]" type="checkbox" value="{{$category.cate_id}}" /></td>
                            <td><a href="{{ url controller='Setup' action='ModifyArea' id=$category.cate_id}}">{{$category.name}}</a></td>
                            <td class="tc">{{$category.created|date_format:'%Y/%m/%d %H:%M:%S'}}</td>
                            <td class="tc"><a href="{{ url controller='Setup' action='ModifyArea' id=$category.cate_id}}">编辑</a> | <a href="{{ url controller='Setup' action='RemoveAreas' id=$category.cate_id}}" onclick="remove_confirm('#listform', this); return(false);">删除</a></td>
                        </tr>

{{ foreach from=$category.children item=child }}
                        <tr>
                            <td class="tc"><input id="check[]" name="check[]" type="checkbox" value="{{$child.cate_id}}" /></td>
                            <td><a href="{{ url controller='Setup' action='ModifyArea' id=$child.cate_id}}"> |- {{$child.name}}</a></td>
                            <td class="tc">{{$child.created|date_format:'%Y/%m/%d %H:%M:%S'}}</td>
                            <td class="tc"><a href="{{ url controller='Setup' action='ModifyArea' id=$child.cate_id}}">编辑</a> | <a href="{{ url controller='Setup' action='RemoveAreas' id=$child.cate_id}}" onclick="remove_confirm('#listform', this); return(false);">删除</a></td>
                        </tr>

{{ foreach from=$child.children item=ch }}
                        <tr>
                            <td class="tc"><input id="check[]" name="check[]" type="checkbox" value="{{$ch.cate_id}}" /></td>
                            <td><a href="{{ url controller='Setup' action='ModifyArea' id=$ch.cate_id}}">&nbsp;&nbsp;&nbsp;|-- {{$ch.name}}</a></td>
                            <td class="tc">{{$ch.created|date_format:'%Y/%m/%d %H:%M:%S'}}</td>
                            <td class="tc"><a href="{{ url controller='Setup' action='ModifyArea' id=$ch.cate_id}}">编辑</a> | <a href="{{ url controller='Setup' action='RemoveAreas' id=$ch.cate_id}}" onclick="remove_confirm('#listform', this); return(false);">删除</a></td>
                        </tr>
{{ /foreach }}
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

