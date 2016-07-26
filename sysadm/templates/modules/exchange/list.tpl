{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='栏目管理' position='兑换列表' footprint='yes' }}

{{ assign var='cmdType' value='exchange' }}

{{ include file='modules/exchange/cmd.tpl' }}

    <div class="layout clearfix">

        <div class="box">
            <h3>兑换列表</h3>
            <form id="listform" name="listform" action="{{ url controller='Exchange' action='Remove' }}" method="post">
                <table class="table-data">
                    <thead>
                        <tr>
                            <th width="5%"><input id="checkall" name="checkall" type="checkbox" /></th>
                            <th width="20%">物品名称</th>
                            <th width="10%">所需积分</th>
                            <th width="15%">兑换人</th>
                            <th width="10%">联系电话</th>
                            <th width="15%">提交日期</th>
                            <th width="5%">兑换状态</th>
                            <th>管理</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th><input class="ibtn" type="button" value="删除所选" onclick="remove_confirm('#listform', '')" /></th>
                            <th colspan="8">
{{ webcontrol type='Pagenav' name='pager' pager=$pager prevLabel='上一页' nextLabel='下一页' controller=$controller action=$action colkey=$colkey lang=$lang search=$search exc_id=$exc_id name=$name username=$username}}
                            </th>
                        </tr>
                    </tfoot>
                    <tbody>
{{ foreach from=$exchanges item=exchange }}
                        <tr>
                            <td class="tc"><input id="check[]" name="check[]" type="checkbox" value="{{ $exchange.exc_id }}" /></td>
                            <td><a href="{{ url controller='Exchange' action='Modify' id=$exchange.exc_id }}">{{ $exchange.prize.name }}</a></td>
                            <td class="tc">{{ $exchange.prize.points }}</td>
                            <td class="tc">{{ $exchange.member.username }}</td>
                            <td class="tc">{{ $exchange.member.phone }}</td>
                            <td class="tc">{{ $exchange.created|date_format:'%Y-%m-%d' }}</td>
                            <td class="tc">{{ if $exchange.state eq 0 }}未兑换{{ else }}已兑换{{ /if }}</td>
                            <td class="tc">
                                <a href="{{ url controller='Exchange' action='Modify' id=$exchange.exc_id }}">查看</a> | 
                                <a href="{{ url controller='Exchange' action='Remove' id=$exchange.exc_id }}" onclick="remove_confirm('#listform', this); return(false);">删除</a>
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
