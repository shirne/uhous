{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='栏目管理' position='订单列表' footprint='yes' }}

{{ assign var='cmdType' value='order' }}

{{ include file='modules/order/cmd.tpl' }}

    <div class="layout clearfix">

        <div class="box">
            <h3>订单列表</h3>
            <form id="listform" name="listform" action="{{ url controller='Order' action='Remove' }}" method="post">
                <table class="table-data">
                    <thead>
                        <tr>
                            <th width="5%"><input id="checkall" name="checkall" type="checkbox" /></th>
                            <th width="5%"></th>
                            <th width="10%">订单号</th>
                            <th width="7%">用户名</th>
                            <th width="7%">收货人</th>
                            <th width="10%">联系电话</th>
                            <th width="20%">收货地址</th>
                            <th width="10%">订单金额</th>
                            <th width="7%">提交日期</th>
                            <th width="5%">状态</th>
                            <th>管理</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th><input class="ibtn" type="button" value="删除所选" onclick="remove_confirm('#listform', '')" /></th>
                            <th colspan="8">
{{ webcontrol type='Pagenav' name='pager' pager=$pager prevLabel='上一页' nextLabel='下一页' controller=$controller action=$action colkey=$colkey lang=$lang search=$search order_id=$order_id name=$name username=$username phone=$phone price=$price}}
                            </th>
                        </tr>
                    </tfoot>
                    <tbody>
{{ foreach from=$orders item=order }}
                        <tr>
                            <td class="tc"><input id="check[]" name="check[]" type="checkbox" value="{{ $order.order_id }}" /></td>
                            <td class="tc">{{ if $order.state eq 6}}<span style="color: red;">退款</span>{{/if}}</td>
                            <td class="tc">{{ $order.ordercode }}</td>
                            <td class="tc">{{ $order.member.username }}</td>
                            <td class="tc">{{ $order.params.username }}</td>
                            <td class="tc">{{ $order.params.phone }}<br />{{$order.params.tel }}</td>
                            <td class="tc">{{$order.address.province.name}} {{$order.address.city.name}} {{$order.address.division.name}} {{ $order.address.address }}</td>
                            <td class="tc">{{ $order.total }}&yen;</td>
                            <td class="tc">{{ $order.created|date_format:'%Y-%m-%d' }}</td>
                            <td class="tc">
                            {{ if $order.state eq 0}}
                                <span style="color:red;">待付款</span>
                            {{ elseif $order.state eq 1 }}
                                <span style="color:red;">已付款</span>
                            {{ elseif $order.state eq 2 }}
                                <span style="color:red;">已发货</span>
                            {{ elseif $order.state eq 3 }}
                                <span style="color:red;">已收货</span>
                            {{ elseif $order.state eq 4 }}
                                <span style="color:red;">待退款</span>
                            {{ elseif $order.state eq 5 }}
                                <span style="color:red;">已退款</span>
                            {{ elseif $order.state eq 7 }}
                                <span style="color:red;">已取消</span>
                            {{ /if }}
                            </td>
                            <td class="tc">
                                <a href="{{ url controller='Order' action='Modify' id=$order.order_id }}">查看</a> | 
                                <a href="{{ url controller='Order' action='Remove' id=$order.order_id }}" onclick="remove_confirm('#listform', this); return(false);">删除</a>
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
