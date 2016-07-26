{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='栏目管理' position='订单搜索' footprint='yes' }}

{{ assign var='cmdType' value='order' }}

{{ include file='modules/order/cmd.tpl' }}

<div class="layout clearfix">

        <div class="box">
            <h3>订单搜索</h3>
            <div class="form">

                <form id="editform" name="editform" action="{{ url controller='Order' search='yes' }}" method="post">
                    <table>
                        <tr>
                            <td>
                                <p>
                                    <label for="name">服务项名称:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="name" name="name" value="" /></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="points">服务项价格:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="prices" name="price" value="" /></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="username">订购人:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="username" name="username" value="" /></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="phone">联系电话:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="phone" name="phone" value="" /></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <input class="ibtn ibtn-ok" type="submit" value="开始搜索" />
                                    <input id="col_key" name="col_key" type="hidden" value="{{$colkey}}" />
                                    <input id="lang" name="lang" type="hidden" value="{{$lang}}" />
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

</body>

</html>
