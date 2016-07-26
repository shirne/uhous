{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ if $smarty.get.colkey eq 'payment' }}
{{ assign var='col_name' value='支付方式' }}
{{ assign var='position' value='支付方式列表' }}
{{ else if $smarty.get.colkey eq 'delivery' }}
{{ assign var='col_name' value='配送方式' }}
{{ assign var='position' value='配送方式列表' }}
{{ /if}}

{{ webcontrol type='Position' name='position' column='栏目管理' position=$col_name footprint='yes' }}

{{ assign var='cmdType' value='setup' }}

{{ include file='modules/setup/cmd.tpl' }}

    <div class="layout clearfix">

        <div class="box">
            <h3>{{$col_name}}列表</h3>
            <form id="listform" name="listform" action="{{ url controller='Setup' action='Remove' }}" method="post">
                <table class="table-data">
                    <thead>
                        <tr>
                            <th width="5%"><input id="checkall" name="checkall" type="checkbox" /></th>
                            <th width="15%">{{$col_name}}名称</th>
                            <th width="50%">描述</th>
                            <th width="12%">费用</th>
                            <th>管理</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th><input class="ibtn" type="button" value="删除所选" onclick="remove_confirm('#listform', '')" /></th>
                            <th colspan="7">
{{ webcontrol type='Pagenav' name='pager' pager=$pager prevLabel='上一页' nextLabel='下一页' controller=$controller action=$action colkey=$colkey lang=$lang search=$search set_id=$set_id title=$title }}
                            </th>
                        </tr>
                    </tfoot>
                    <tbody>
{{ foreach from=$setups item=setup }}
                        <tr>
                            <td class="tc"><input id="check[]" name="check[]" type="checkbox" value="{{ $setup.set_id }}" /></td>
                            <td class="tc"><a href="{{ url controller='Setup' action='Modify' id=$setup.set_id }}">{{ $setup.name }}</a></td>
                            <td>{{ $setup.memo }}</td>
                            <td class="tc">￥{{ $setup.cost }}</td>
                            <td class="tc"><a href="{{ url controller='Setup' action='Modify' id=$setup.set_id }}">编辑</a> | <a href="{{ url controller='Setup' action='Remove' id=$setup.set_id }}" onclick="remove_confirm('#listform', this); return(false);">删除</a></td>
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

