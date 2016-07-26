{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='栏目管理' position='行业列表' footprint='yes' }}

{{ assign var='cmdType' value='business' }}

{{ include file='modules/merchant/cmd.tpl' }}

    <div class="layout clearfix">

        <div class="box">
            <h3>行业列表</h3>
            <form id="listform" name="listform" action="{{ url controller='Merchant' action='RemoveBusiness' }}" method="post">
                <table class="table-data">
                    <thead>
                        <tr>
                            <th width="5%"><input id="checkall" name="checkall" type="checkbox" /></th>
                            <th width="25%">行业名称</th>
                            <th width="10%">创建日期</th>
                            <th>管理</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th><input class="ibtn" type="button" value="删除所选" onclick="remove_confirm('#listform', '')" /></th>
                            <th colspan="7">
{{ webcontrol type='Pagenav' name='pager' pager=$pager prevLabel='上一页' nextLabel='下一页' controller=$controller action=$action colkey=$colkey lang=$lang search=$search }}
                            </th>
                        </tr>
                    </tfoot>
                    <tbody>
{{ foreach from=$businesses item=business }}
                        <tr>
                            <td class="tc"><input id="check[]" name="check[]" type="checkbox" value="{{ $business.business_id }}" /></td>
                            <td><a href="{{ url controller='Merchant' action='ModifyBusiness' id=$business.business_id }}">{{ $business.name }}</a></td>
                            <td class="tc">{{ $business.created|date_format:'%Y-%m-%d' }}</td>
                            <td class="tc">
                                <a href="{{ url controller='Merchant' action='ModifyBusiness' id=$business.business_id }}">编辑</a> | 
                                <a href="{{ url controller='Merchant' action='RemoveBusiness' id=$business.business_id }}" onclick="remove_confirm('#listform', this); return(false);">删除</a>
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
