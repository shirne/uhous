{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='栏目管理' position='广告列表' footprint='yes' }}

{{ assign var='cmdType' value='advertise' }}

{{ include file='modules/advertise/cmd.tpl' }}

    <div class="layout clearfix">

        <div class="box">
            <h3>广告列表</h3>
            <form id="listform" name="listform" action="{{ url controller='Advertise' action='Remove' }}" method="post">
                <table class="table-data">
                    <thead>
                        <tr>
                            <th width="5%"><input id="checkall" name="checkall" type="checkbox" /></th>
                            <th width="20%">广告标题</th>
                            <th width="30%">广告图片</th>
                            <th width="25%">广告链接</th>
                            <th>管理</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th><input class="ibtn" type="button" value="删除所选" onclick="remove_confirm('#listform', '')" /></th>
                            <th colspan="7">
{{ webcontrol type='Pagenav' name='pager' pager=$pager prevLabel='上一页' nextLabel='下一页' controller=$controller action=$action colkey=$colkey lang=$lang search=$search adv_id=$adv_id title=$title }}
                            </th>
                        </tr>
                    </tfoot>
                    <tbody>
{{ foreach from=$advertises item=advertise }}
                        <tr>
                            <td class="tc"><input id="check[]" name="check[]" type="checkbox" value="{{ $advertise.adv_id }}" /></td>
                            <td><a href="{{ url controller='Advertise' action='Modify' id=$advertise.adv_id }}">{{ $advertise.title }}</a></td>
                            <td class="tc"><img src="/{{ get_app_inf key='uploadDir' }}{{ $advertise.pic }}" height="60" /></td>
                            <td class="tc"><a href="{{ $advertise.url }}">{{ $advertise.url }}</a></td>
                            <td class="tc"><a href="{{ url controller='Advertise' action='Modify' id=$advertise.adv_id }}">编辑</a> | <a href="{{ url controller='Advertise' action='Remove' id=$advertise.adv_id }}" onclick="remove_confirm('#listform', this); return(false);">删除</a></td>
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

