{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='系统管理' position='支付宝参数设置' printfoot=false }}

    <div class="layout clearfix mt">

        <div class="box">
            <h3>支付宝参数设置</h3>
            <div class="form">

                <form id="editform" name="editform" action="{{ url controller='Settings' action='SaveAlipay' }}" method="post">
                    <table>
                        <tr>
                            <td>
                                <p>
                                    <label for="partner_id">用户ID:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="partner_id" name="partner_id" value="{{$partner_id}}" /></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="key">验证Key:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="key" name="key" value="{{$key}}" /></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="seller_email">商户邮箱:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="seller_email" name="seller_email" value="{{$seller_email}}" /></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <input class="ibtn ibtn-ok" type="submit" value="保存设置" />
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

