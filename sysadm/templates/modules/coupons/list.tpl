{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='栏目管理' position='优惠券列表' footprint='yes' }}

{{ assign var='cmdType' value='coupon' }}

{{ include file='modules/coupons/cmd.tpl' }}

    <div class="layout clearfix">

        <div class="box">
            <h3>优惠券列表</h3>
            <form id="listform" name="listform" action="{{ url controller='Coupons' action='Remove' }}" method="post">
                <table class="table-data">
                    <thead>
                        <tr>
                            <th width="5%"><input id="checkall" name="checkall" type="checkbox" /></th>
                            <th width="10%">优惠券名称</th>
                            <th width="25%">优惠券图片</th>
                            <th width="12%">价值</th>
                            <th width="12%">最小订单金额</th>
                            <th width="12%">截止日期</th>
                            <th>管理</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th><input class="ibtn" type="button" value="删除所选" onclick="remove_confirm('#listform', '')" /></th>
                            <th colspan="7">
{{ webcontrol type='Pagenav' name='pager' pager=$pager prevLabel='上一页' nextLabel='下一页' controller=$controller action=$action colkey=$colkey lang=$lang search=$search cou_id=$cou_id title=$title }}
                            </th>
                        </tr>
                    </tfoot>
                    <tbody>
{{ foreach from=$coupons item=coupon }}
                        <tr>
                            <td class="tc"><input id="check[]" name="check[]" type="checkbox" value="{{ $coupon.cou_id }}" /></td>
                            <td class="tc"><a href="{{ url controller='Coupons' action='Modify' id=$coupon.cou_id }}">{{ $coupon.name }}</a></td>
                            <td class="tc"><img src="/{{ get_app_inf key='uploadDir' }}{{ $coupon.pic }}" height="60" /></td>
                            <td class="tc">￥{{ $coupon.value }}</td>
                            <td class="tc">￥{{ $coupon.minprice }}</td>
                            <td class="tc">{{ $coupon.period|date_format:'%Y-%m-%d' }}</td>
                            <td class="tc"><a href="{{ url controller='Coupons' action='Modify' id=$coupon.cou_id }}">编辑</a> | <a href="{{ url controller='Coupons' action='Remove' id=$coupon.cou_id }}" onclick="remove_confirm('#listform', this); return(false);">删除</a></td>
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

