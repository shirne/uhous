{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='栏目管理' position='信息列表' footprint='yes' }}

{{ assign var='cmdType' value='information' }}

{{ include file='modules/information/cmd.tpl' }}

    <div class="layout clearfix">

        <div class="box">
            <h3>信息列表</h3>
            <form id="listform" name="listform" action="{{ url controller='Information' action='Remove' }}" method="post">
                <table class="table-data">
                    <thead>
                        <tr>
                            <th width="5%">
                                {{ if $colkey eq 'info' }}
                                <input id="checkall" name="checkall" type="checkbox" />
                                {{ /if }}
                            </th>
                            <th width="45%">信息标题</th>
                            <th width="15%">发布日期</th>
                            <th>管理</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>
                                {{ if $colkey eq 'info' }}
                                <input class="ibtn" type="button" value="删除所选" onclick="remove_confirm('#listform', '')" />
                                {{ /if }}
                            </th>
                            <th colspan="4">
{{ webcontrol type='Pagenav' name='pager' pager=$pager controller=$controller action=$action colkey=$colkey lang=$lang cate=$cate search=$search title=$title info_id=$info_id prevLabel='上一页' nextLabel='下一页' }}
                            </th>
                        </tr>
                    </tfoot>
                    <tbody>
{{ foreach from=$informations item=info }}
                        <tr>
                            <td class="tc">
                                {{ if $colkey eq 'info' }}
                                    
                                <input id="check[]" name="check[]" type="checkbox" value="{{$info.info_id}}" />
                                {{ else }}
                                {{ /if }}
                            </td>
                            <td>{{ if $info.pic }}<span class="red">[图]</span>{{ /if }}<a href="{{ url controller='Information' action='Modify' id=$info.info_id }}">{{$info.title}}</a></td>
                            <td class="tc">{{$info.created|date_format:'%Y/%m/%d %H:%M:%S'}}</td>
                            <td class="tc">
                                <a href="{{ url controller='Information' action='Modify' id=$info.info_id }}">编辑</a>
{{ if $colkey eq 'info' }}
                                | <a href="{{ url controller='Information' action='Remove' id=$info.info_id }}" onclick="remove_confirm('#listform', this); return(false);">删除</a>
{{ /if }}
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

