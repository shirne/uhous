{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='栏目管理' position='物品搜索' footprint='yes' }}

{{ assign var='cmdType' value='prize' }}

{{ include file='modules/exchange/cmd.tpl' }}

<div class="layout clearfix">

        <div class="box">
            <h3>物品搜索</h3>
            <div class="form">

                <form id="editform" name="editform" action="{{ url controller='Exchange' action='Prize' search='yes' }}" method="post">
                    <table>
                        <tr>
                            <td>
                                <p>
                                    <label for="prize_id">物品ID:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="prize_id" name="prize_id" value="" /></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="name">物品名称:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="name" name="name" value="" /></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="points">兑换物品所需积分:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="points" name="points" value="" /></b></b>
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

