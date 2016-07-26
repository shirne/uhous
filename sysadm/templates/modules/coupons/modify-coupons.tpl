{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ if $coupon.cou_id }}

    {{ assign var='label' value='编辑优惠券' }}

{{ else }}

    {{ assign var='label' value='添加优惠券' }}

{{ /if }}

{{ webcontrol type='Position' name='position' column='栏目管理' position=$label footprint='yes' }}

{{ include file='modules/coupons/cmd.tpl' }}

    <div class="layout clearfix">

        <div class="box">
            <h3>{{ $label }}</h3>
            <div class="form">
            <form id="editform" name="editform" action="{{ url controller='Coupons' action='Save' }}" method="post"  enctype="multipart/form-data">
                <table>
                    <tr>
                        <td>
                            <p>
                                <label for="name">优惠券名称:</label>
                                <b class="fluid-input"><b class="fluid-input-inner">
                                <input class="itext" type="text" id="name" name="name" value="{{ $coupon.name }}" />
                                </b></b>
                            </p>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <p>
                                <label for="value">价值￥:</label>
                                <b class="fluid-input"><b class="fluid-input-inner">
                                <input class="itext" type="text" id="value" name="value" value="{{ $coupon.value }}" />
                                </b></b>
                            </p>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <p>
                                <label for="minprice">最小订单金额￥:</label>
                                <b class="fluid-input"><b class="fluid-input-inner">
                                <input class="itext" type="text" id="minprice" name="minprice" value="{{ $coupon.minprice }}" />
                                </b></b>
                                <small>即此优惠券在次金额以上的订单才能使用</small>
                            </p>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <p>
                                <label for="invaluetype">限期方式:</label>
                                <b class="fluid-input"><b class="fluid-input-inner">
                                <select class="itext" id="invaluetype" name="invaluetype">
                                    <option value="0">限定日期</option>
                                    <option value="1"{{if $coupon.invaluetype}} selected{{/if}}>限定时间</option>
                                </select>
                                </b></b>
                                <small>限定日期:即到指定时间所有该类型优惠卡都过期，修改之前赠送的不影响<br />限定时间:即从赠送时间开始计时，在指定时间内有效</small>
                            </p>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <p>
                                <label for="period">限定日期:</label>
                                <b class="fluid-input"><b class="fluid-input-inner">
                                <input class="itext" type="text" id="period" name="period" value="{{ $coupon.period|date_format:'%Y-%m-%d' }}" />
                                </b></b>
                                <small>直接填写截止日期，如：2012-01-01</small>
                            </p>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <p>
                                <label for="exprise">限定时间:</label>
                                <b class="fluid-input"><b class="fluid-input-inner">
                                <select class="itext" id="exprise" name="exprise" >
                                    <option value="2678400">一个月</option>
                                    <option value="7948800"{{if $coupon.exprise == 7948800}} selected{{/if}}>三个月</option>
                                    <option value="15897600"{{if $coupon.exprise == 15897600}} selected{{/if}}>六个月</option>
                                    <option value="31536000"{{if $coupon.exprise == 31536000}} selected{{/if}}>一年</option>
                                    <option value="63072000"{{if $coupon.exprise == 63072000}} selected{{/if}}>二年</option>
                                    <option value="94694400"{{if $coupon.exprise == 94694400}} selected{{/if}}>三年</option>
                                    <option value="157766400"{{if $coupon.exprise == 157766400}} selected{{/if}}>五年</option>
                                </select>
                                </b></b>
                                <small>修改时同时更新到已赠送的优惠卡限期</small>
                            </p>
                        </td>
                        <td></td>
                    </tr>
                        <tr>
                            <td colspan="3">
                                <p>
                                    <label for="pic">优惠券示意图:</label>
                                    {{ if $coupon.pic }}

                                    <div>
                                        <img src="/{{ get_app_inf key='uploadDir' }}{{ $coupon.pic }}" height="32" />
                                        <a href="/{{ get_app_inf key='uploadDir' }}{{ $coupon.pic }}" target="_blank">查看原图</a> | <a href="{{ url controller='Coupons' action='RemovePic' id=$coupon.cou_id }}">删除图片</a>
                                    </div>
                                    <small>如需要重新上传图片，须先删除图片。</small>

                                    {{ else }}

                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="file" id="pic" name="pic" /></b></b>

                                    {{ /if }}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <p>
                                    <input class="ibtn ibtn-ok" type="submit" value="保存" />
                                    <input id="cou_id" name="cou_id" type="hidden" value=" {{ $coupon.cou_id }} " />
                                    <input id="col_key" name="col_key" type="hidden" value="{{ $col_key}}" />
                                    <input id="lang" name="lang" type="hidden" value="{{ $lang }}" />
                                </p>
                            </td>
                        </tr>

                </table>
            </form>
            </div>
        </div>

    </div>

</div>

</body>

</html>
