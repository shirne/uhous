{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='栏目管理' position='物品列表' footprint='yes' }}

{{ assign var='cmdType' value='prize' }}

{{ include file='modules/exchange/cmd.tpl' }}

    <div class="layout clearfix">

        <div class="box">
            <h3>物品列表</h3>
            <form id="listform" name="listform" action="{{ url controller='Exchange' action='RemovePrize' }}" method="post">
                <table class="table-data">
                    <thead>
                        <tr>
                            <th width="5%"><input id="checkall" name="checkall" type="checkbox" /></th>
                            <th width="30%">物品名称</th>
                            <th width="15%">所需积分</th>
                            <th width="15%">物品数量</th>
                            <th width="15%">添加日期</th>
                            <th>管理</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th><input class="ibtn" type="button" value="删除所选" onclick="remove_confirm('#listform', '')" /></th>
                            <th colspan="8">
{{ webcontrol type='Pagenav' name='pager' pager=$pager prevLabel='上一页' nextLabel='下一页' controller=$controller action=$action colkey=$colkey lang=$lang search=$search prize_id=$prize_id name=$name}}
                            </th>
                        </tr>
                    </tfoot>
                    <tbody>
{{ foreach from=$prizes item=prize }}
                        <tr>
                            <td class="tc"><input id="check[]" name="check[]" type="checkbox" value="{{ $prize.exc_id }}" /></td>
                            <td><a href="{{ url controller='Exchange' action='ModifyPrize' id=$prize.priz_id }}">{{ $prize.name }}</a></td>
                            <td class="tc">{{ $prize.points }}</td>
                            <td class="tc">{{ $prize.amount }}</td>
                            <td class="tc">{{ $prize.created|date_format:'%Y-%m-%d' }}</td>
                            <td class="tc">
                                <a href="{{ url controller='Exchange' action='ModifyPrize' id=$prize.prize_id }}">修改</a> | 
                                <a href="{{ url controller='Exchange' action='RemovePrize' id=$prize.prize_id }}" onclick="remove_confirm('#listform', this); return(false);">删除</a>
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
