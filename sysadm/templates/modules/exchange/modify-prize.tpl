{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ if $prize.prize_id }}
    {{ assign var='label' value='编辑物品' }}
{{ else }}
    {{ assign var='label' value='添加物品' }}
{{ /if }}

{{ webcontrol type='Position' name='position' column='栏目管理' position=$label footprint='yes' }}

{{ assign var='cmdType' value='prize' }}

{{ include file='modules/exchange/cmd.tpl' }}

<div class="layout clearfix">

        <div class="box">
            <h3>{{ $label }}</h3>
            <div class="form">

                <form id="editform" name="editform" action="{{ url controller='Exchange' action='SavePrize' }}" method="post"  enctype="multipart/form-data">
                    <table>
                        <tr>
                            <td width="20%">
                                <p>
                                    <label for="name">物品名称:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <input type="text" class="itext" id="name" name="name" value="{{ $prize.name }}" />
                                    </b></b>
                                </p>
                            </td>
                            <td width="2%"></td>
                            <td width="20%">
                                <p>
                                    <label for="points">所需积分:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <input type="text" class="itext" id="points" name="points" value="{{ if $prize.prize_id }}{{ $prize.points }}{{ else }}{{ option key='default_need_points' }}{{ /if }}" />
                                    </b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td width="20%">
                                <p>
                                    <label for="amount">物品数量:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <input type="text" class="itext" id="amount" name="amount" value="{{ $prize.amount }}" />
                                    </b></b>
                                    <small>添加物品时填写，数量会因兑换而减少</small>
                                </p>
                            </td>
                            <td width="2%"></td>
                            <td width="20%">
                                <p>
                                    <label for="exchange_times">已兑换次数:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <input type="text" class="itext" id="exchange_times" name="exchange_times" value="{{ $prize.exchange_times }}" />
                                    </b></b>
                                    <small>根据兑换次数增加，无须修改</small>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td width="20%">
                                <p>
                                    <label for="pic">物品图片:</label>
{{ if $prize.pic }}
                                    <div>
                                        <img src="/{{ get_app_inf key='uploadDir' }}{{$prize.pic}}" height="32" />
                                        <a href="/{{ get_app_inf key='uploadDir' }}{{$prize.pic}}" target="_blank">查看原图</a> | <a href="{{ url controller='Exchange' action='RemovePrizePic' id=$prize.prize_id }}">删除图片</a>
                                    </div>
                                    <small>如需要重新上传图片，须先删除图片。</small>
{{ else }}
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="file" id="pic" name="pic" /></b></b>
                                    <small>图片尺寸：360px X 360px (像素)。</small>
{{ /if }}
                                </p>
                            </td>
                            <td width="2%"></td>
                            <td width="20%">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <p>
                                    <label for="memo">物品描述:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    {{ webcontrol type='Editor' name='memo' value=$prize.memo style='Basic' height='120' }}
                                    </b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <input class="ibtn ibtn-ok" type="submit" value="保存" />
                                    <input type="hidden" name="prize_id" id="prize_id" value="{{ $prize.prize_id }}" />
                                    <input type="hidden" name="lang" id="lang" value="{{ $prize.lang }}" />
                                    <input type="hidden" name="col_key" id="col_key" value="{{ $prize.col_key }}" />
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
