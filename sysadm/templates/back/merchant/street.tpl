{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='栏目管理' position='街道列表' footprint='yes' }}

{{ assign var='cmdType' value='street' }}

{{ include file='modules/merchant/cmd.tpl' }}

    <div class="layout clearfix">

        <div class="box">
            <h3>街道列表</h3>
            <form id="listform" name="listform" action="{{ url controller='Merchant' action='RemoveStreet' }}" method="post">
                <table class="table-data">
                    <thead>
                        <tr>
                            <th width="5%"><input id="checkall" name="checkall" type="checkbox" /></th>
                            <th width="25%">街道名称</th>
                            <th width="20%">所属区域</th>
                            <th width="10%">创建日期</th>
                            <th>管理</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th><input class="ibtn" type="button" value="删除所选" onclick="remove_confirm('#listform', '')" /></th>
                            <th colspan="7">
{{ webcontrol type='Pagenav' name='pager' pager=$pager prevLabel='上一页' nextLabel='下一页' controller=$controller action=$action colkey=$colkey lang=$lang search=$search street=$street_id }}
                            </th>
                        </tr>
                    </tfoot>
                    <tbody>
{{ foreach from=$streets item=street }}
                        <tr>
                            <td class="tc"><input id="check[]" name="check[]" type="checkbox" value="{{ $street.street_id }}" /></td>
                            <td><a href="{{ url controller='Merchant' action='ModifyStreet' id=$street.street_id }}">{{ $street.name }}</a></td>
                            <td class="tc"><a href="{{ url controller='Merchant' action='Area' id=$street.area.cate_id }}">{{ $street.area.name }}</a></td>
                            <td class="tc">{{ $street.created|date_format:'%Y-%m-%d' }}</td>
                            <td class="tc">
                                <a href="{{ url controller='Merchant' action='ModifyStreet' id=$street.street_id }}">编辑</a> | 
                                <a href="{{ url controller='Merchant' action='RemoveStreet' id=$street.street_id }}" onclick="remove_confirm('#listform', this); return(false);">删除</a>
                            </td>
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
