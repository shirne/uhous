{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='栏目管理' position='属性设置' footprint='yes' }}

{{ assign var='cmdType' value='foods' }}

{{ include file='modules/merchant/cmd.tpl' }}

<div class="layout clearfix">

        <div class="box">
            <h3>属性设置</h3>
            <div class="form">

                <form id="editform" name="editform" action="{{ url controller='Merchant' action='SaveSetup' }}" method="post">
                    <table>
                        <tr>
                            <td width="32%">
                                <p>
                                    <h5>功能待定</h5>
                                    <label for=""></label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                        <!--<input style="width: 32%;" class="itext" id="default_need_points" name="default_need_points" value="{{ $default_need_points.value }}" />-->
                                    </b></b>
                                </p>
                            </td>
                        </tr>
                         <tr>
                            <td>
                                <p>
                                    <input class="ibtn ibtn-ok" type="submit" value="保存" />
                                    <input id="opt_id" name="opt_id" type="hidden" value="{{$default_need_points.opt_id}}" />
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
