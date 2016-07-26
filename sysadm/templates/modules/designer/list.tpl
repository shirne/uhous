{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='栏目管理' position='设计师列表' footprint='yes' }}

{{ assign var='cmdType' value='designer' }}

{{ include file='modules/designer/cmd.tpl' }}

    <div class="layout clearfix">

        <div class="box">
            <h3>设计师列表</h3>
            <form id="listform" name="listform" action="{{ url controller='Designer' action='Remove' }}" method="post">
                <table class="table-data">
                    <thead>
                        <tr>
                            <th width="5%">
                                <input id="checkall" name="checkall" type="checkbox" />
                            </th>
                            <th width="15%">设计师名称</th>
                            <th width="25%">头像</th>
                            <th width="15%">设计师风格</th>
                            <th width="15%">加入日期</th>
                            <th>管理</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>
                                <input class="ibtn" type="button" value="删除所选" onclick="remove_confirm('#listform', '')" />
                            </th>
                            <th colspan="6">
{{ webcontrol type='Pagenav' name='pager' pager=$pager controller=$controller action=$action colkey=$colkey lang=$lang cate=$cate search=$search title=$title des_id=$des_id prevLabel='上一页' nextLabel='下一页' }}
                            </th>
                        </tr>
                    </tfoot>
                    <tbody>
{{ foreach from=$designers item=des }}
                        <tr>
                            <td class="tc">
                                <input id="check[]" name="check[]" type="checkbox" value="{{$des.des_id}}" />
                            </td>
                            <td><a href="{{ url controller='Designer' action='Modify' id=$des.des_id }}">{{$des.name}}</a></td>
                            <td class="tc"><img src="/{{ get_app_inf key='uploadDir' }}{{$des.photo}}" height="60" /></td>
                            <td>{{$des.style}}</td>
                            <td class="tc">{{$des.created|date_format:'%Y/%m/%d %H:%M:%S'}}</td>
                            <td class="tc">
                                <a href="{{ url controller='Designer' action='Modify' id=$des.des_id }}">编辑</a>
                                | <a href="{{ url controller='Designer' action='Remove' id=$des.des_id }}" onclick="remove_confirm('#listform', this); return(false);">删除</a>
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

