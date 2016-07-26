{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='栏目管理' position='属性设置' footprint='yes' }}

{{ assign var='cmdType' value='setup' }}

{{ include file='modules/exchange/cmd.tpl' }}

<div class="layout clearfix">

        <div class="box">
            <h3>属性设置</h3>
            <div class="form">

                <form id="editform" name="editform" action="{{ url controller='Exchange' action='SaveSetup' }}" method="post">
                    <table>
                        <tr>
                            <td width="32%">
                                <p>
                                    <label for="default_need_points">物品默认兑换积分:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                        <input style="width: 32%;" class="itext" id="default_need_points" name="default_need_points" value="{{ $default_need_points.value }}" />
                                    </b></b>
                                </p>
                            </td>
                        </tr>
                         <tr>
                            <td>
                                <p>
                                    <input class="ibtn ibtn-ok" type="submit" value="保存" />
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
