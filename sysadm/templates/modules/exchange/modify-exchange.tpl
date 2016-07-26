{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='栏目管理' position='查看兑换' footprint='yes' }}

{{ assign var='cmdType' value='exchange' }}

{{ include file='modules/exchange/cmd.tpl' }}

<div class="layout clearfix">

        <div class="box">
            <h3>查看兑换</h3>
            <div class="form">

                <form id="editform" name="editform" action="{{ url controller='Exchange' action='SetExchanged' exc_id=$exchange.exc_id }}" method="post"  enctype="multipart/form-data">
                    <table>
                        <tr>
                            <td width="20%" rowspan="2">
                                <p>
                                    <label for="pic">物品图片:</label>
                                    <div class="tc">
                                        <a href="/{{ get_app_inf key='uploadDir' }}{{$merchant.logo}}" target="_blank" title="查看原图">
                                            <img src="/{{ get_app_inf key='uploadDir' }}{{$exchange.prize.pic}}" height="128px" />
                                        </a> 
                                    </div>
                                </p>
                            </td>
                            <td width="2%"></td>
                            <td width="20%">
                                <p>
                                    <label for="name">物品名称:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <div class="itext" style="font-weight: normal;">{{ $exchange.prize.name }}</div>
                                    </b></b>
                                </p>
                            </td>
                            <td width="2%"></td>
                            <td width="20%">
                                <p>
                                    <label for="amount">物品数量:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <div class="itext" style="font-weight: normal;">{{ $exchange.prize.amount }}</div>
                                    </b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td width="20%">
                                <p>
                                    <label for="points">所需积分:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <div class="itext" style="font-weight: normal;">{{ $exchange.prize.points }}</div>
                                    </b></b>
                                </p>
                            </td>
                            <td width="2%"></td>
                            <td width="20%">
                                <p>
                                    <label for="state">兑换状态:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <div class="itext" style="font-weight: normal;">
{{ if $exchange.state eq 0 }} 未兑换 {{ else }} 已兑换 {{ /if }}
                                    
                                    </div>
                                    <input type="hidden" name="state" id="state" value="1" />
                                    </b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td width="20%">
                                <p>
                                    <label for="member">兑换人:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <div class="itext" style="font-weight: normal;">{{ $exchange.member.username }}</div>
                                    </b></b>
                                </p>
                            </td>
                            <td width="2%"></td>
                            <td width="20%">
                                <p>
                                    <label for="phone">兑换人电话:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <div class="itext" style="font-weight: normal;">{{ $exchange.member.phone }}</div>
                                    </b></b>
                                </p>
                            </td>
                            <td width="2%"></td>
                            <td width="20%">
                                <p>
                                    <label for="QQ">兑换人QQ:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <div class="itext" style="font-weight: normal;">{{ $exchange.member.qq }}</div>
                                    </b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <p>
                                    <label for="userAddress">联系人地址:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <div class="itext" style="font-weight: normal;">{{ $exchange.member.address }}</div>
                                    </b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td width="20%">
                                <p>

                                    {{ if $exchange.state eq 0 }}<input class="ibtn ibtn-ok" type="submit" value="设为已兑换" />{{ /if }}

                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <input type="hidden" name="exc_id" id="exc_id" value="{{ $exchange.exc_id }}" />
                                    <input type="hidden" name="lang" id="lang" value="{{ $exchange.lang }}" />
                                    <input type="hidden" name="col_key" id="col_key" value="{{ $exchange.col_key }}" />
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
