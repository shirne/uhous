{{ include file='layouts/head.tpl' }}
<style type="text/css">span { font-weight: normal; }</style>
<div class="inner-content">

{{ webcontrol type='Position' name='position' column='栏目管理' position='查看订单' footprint='yes' }}

{{ assign var='cmdType' value='order' }}

{{ include file='modules/order/cmd.tpl' }}

<div class="layout clearfix">

        <div class="box">
            <h3>查看订单</h3>
            <div class="form">

                <form id="editform" name="editform" action="{{ url controller='Order' action='Disabled' order_id=$order.order_id }}" method="post" >
                    <table>
                        <tr>

                        </tr>
                        <tr>
                            <td width="20%">
                                <p>
                                    <label for="username">收货人:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <div class="itext"><span>{{ $order.params.username }}</span></div>
                                    </b></b>
                                </p>
                            </td>
                            <td width="2%"></td>
                            <td width="20%">
                                <p>
                                    <label for="phone">手机号码:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <div class="itext"><span>{{ $order.params.phone }}</span></div>
                                    </b></b>
                                </p>
                            </td>
                            <td width="2%"></td>
                            <td width="20%">
                                <p>
                                    <label for="tel">固定电话:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <div class="itext"><span>{{ $order.params.tel }}</span></div>
                                    </b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td width="20%">
                                <p>
                                    <label for="email">Email:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <div class="itext"><span>{{ $order.params.email }}</span></div>
                                    </b></b>
                                </p>
                            </td>
                            <td width="2%"></td>
                            <td width="20%">
                                <p>
                                    <label for="post">邮政编码:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <div class="itext"><span>{{ $order.params.post }}</span></div>
                                    </b></b>
                                </p>
                            </td>
                            <td width="2%"></td>
                            <td width="20%">
                                <p>
                                    <label for="tel">最佳配送时间:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <div class="itext"><span>{{ $order.params.besttime }}</span></div>
                                    </b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <p>
                                    <label for="address">收货地址:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <div class="itext"><span>{{ $order.params.address.province.name }} {{ $order.params.address.city.name }} {{ $order.params.address.division.name }} {{ $order.params.address.address }}</span></div>
                                    </b></b>
                                </p>
                            </td>
                            <td width="2%"></td>
                            <td width="20%">
                                <p>
                                    <label for="building">标志建筑:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <div class="itext"><span>{{ $order.params.building }}</span></div>
                                    </b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td width="20%">
                                <p>
                                    <label for="total">订单金额:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <div class="itext"><span>{{ $order.total }}&yen;</span></div>
                                    </b></b>
                                </p>
                            </td>
                            <td width="2%"></td>
                            <td width="20%">
                                <p>
                                    <label for="state">订单状态:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <div class="itext">
                                        <span>
                                        {{ if $order.state eq 1 }} 
                                            已付款
                                        {{ elseif $order.state eq 2 }} 
                                            已发货
                                        {{ elseif $order.state eq 3 }} 
                                            已收货
                                        {{ elseif $order.state eq 4 }} 
                                            待退款 
                                        {{ elseif $order.state eq 5 }} 
                                            已退款 
                                        {{ elseif $order.state eq 7 }} 
                                            已取消 
                                        {{ else }} 
                                            待付款
                                        {{ /if }}
                                        </span>
                                    </div>
                                    <input type="hidden" name="state" id="state" value="0" />
                                    </b></b>
                                </p>
                            </td>
                            <td width="2%"></td>
                            <td width="20%">
                                <p>
                                    <label for="submit">操作:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                        <select id="selectState" name="state">
                                            <option>选择...</option>
                                            <option {{if $order.state eq 0}}selected="selected"{{/if}} value='0'>待付款</option>
                                            <option {{if $order.state eq 1}}selected="selected"{{/if}} value='1'>已付款</option>
                                            <option {{if $order.state eq 2}}selected="selected"{{/if}} value='2'>已发货</option>
                                            <option {{if $order.state eq 3}}selected="selected"{{/if}} value='3'>已收货</option>
                                            <option {{if $order.state eq 4}}selected="selected"{{/if}} value='4'>待退款</option>
                                            <option {{if $order.state eq 5}}selected="selected"{{/if}} value='5'>已退款</option>
                                        </select>
                                        <input class="ibtn ibtn-ok" type="submit" value="确定" />
                                    </b></b>
                                </p>
                            </td>
                        </tr>
                        <tr id="deliveryWay">
                            <td colspan="5">
                                <div>
                                    <select id="selectDelivery" name="delivery_way[deliveryL]">
                                        <option>--选择快递--</option>
                                        {{ foreach from=$deliverys item='del' }}
                                        <option {{ if $del.name eq $order.delivery_way.deliveryC }}selected="selected"{{/if}} value="{{$del.params.link}}">{{$del.name}}</option>
                                        {{/foreach}}
                                    </select>
                                    <span>物流号</span>：<input type="text" name="delivery_way[deliveryNo]" value="{{$order.delivery_way.deliveryNo}}" />
                                    <input type="hidden" id="deliveryName"  name="delivery_way[deliveryC]" value="" />
                                    <input type="submit" class="ibtn ibtn-ok" name="save" value="保存" />
                                </div>
                                <div class="clear"></div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <p>
                                    <fieldset class="fold">
                                        <legend>发票信息</legend>
                                        <div>
{{ if $order.params.bill.checked eq 'yes' }}
                                        <table style="width: 50%">
                                            <tr><th>发票类型：</th><td>{{$order.params.bill.type}}</td><th>发票抬头：</th><td>{{$order.params.bill.header}}</td></tr>
                                            <tr>
                                            {{if $order.params.bill.unitname}}
                                                <th>单位名称：</th><td>{{$order.params.bill.unitname}}</td>
                                                <th>发票内容：</th><td>{{$order.params.bill.content}}</td>
                                            {{else}}
                                                <th>发票内容：</th><td>{{$order.params.bill.content}}</td>
                                                <td></td><td></td>
                                            {{/if}}
                                            </tr>
                                        </table>
{{ else }}

{{ /if }}
                                        </div>
                                    </fieldset>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <p>
                                    <fieldset class="fold">
                                        <legend>产品列表</legend>
                                        <div>
                                            <ul class="piclist clearfix">
                                                {{ foreach from=$order.products item='pro' }}
                                                <li style="width: 200px;">
                                                    <a class="pic" href="{{ url controller='Products' action='Modify' id=$pro.pro_id }}">
                                                        <img src="/{{ get_app_inf key='uploadDir' }}{{$pro.pic}}" height="80" />
                                                    </a>
                                                    <div class="clear"><!--Clear Float--></div>
                                                    <div class="" style="width: 200px;">
                                                        <p>
                                                           <a href="{{ url controller='Products' action='Modify' id=$pro.pro_id }}"><span class="red">{{ $pro.name }}</span></a>
                                                        </p>
                                                        <p>颜色：{{ $pro.params.color }}</p>
                                                        <p>尺寸：{{ $pro.params.size }}</p>
                                                        <p>数量：{{ $pro.num }} X {{ $pro.price }}&yen;</p>
                                                    </div>
                                                    <div class="clear"></div>
                                                </li>
                                                {{ /foreach }}
                                            </ul>
                                        </div>
                                    </fieldset>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <input type="hidden" name="order_id" id="order_id" value="{{ $order.order_id }}" />
                                    <input type="hidden" name="lang" id="lang" value="{{ $order.lang }}" />
                                    <input type="hidden" name="col_key" id="col_key" value="{{ $order.col_key }}" />
                                </p>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>

        <div class="clear"><!-- Clear Float --></div>

    </div>

</div>

<script type="text/javascript">
jQuery(function($) {

    $("#selectDelivery").change(function() {
        $("#deliveryName").val($("#selectDelivery option:selected").text());
    });
});
</script>

</body>

</html>
