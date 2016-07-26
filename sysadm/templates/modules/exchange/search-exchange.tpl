{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='栏目管理' position='兑换搜索' footprint='yes' }}

{{ assign var='cmdType' value='exchange' }}

{{ include file='modules/exchange/cmd.tpl' }}

<div class="layout clearfix">

        <div class="box">
            <h3>兑换搜索</h3>
            <div class="form">

                <form id="editform" name="editform" action="{{ url controller='Exchange' search='yes' }}" method="post">
                    <table>
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
                                    <label for="points">物品兑换所需积分:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="points" name="points" value="" /></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="username">兑换人:</label>
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
