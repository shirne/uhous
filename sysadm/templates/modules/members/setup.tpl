{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='栏目管理' position='属性设置' footprint='yes' }}

{{ assign var='cmdType' value='setup' }}

{{ include file='modules/members/cmd.tpl' }}

<div class="layout clearfix">

        <div class="box">
            <h3>属性设置</h3>
            <div class="form">

                <form id="editform" name="editform" action="{{ url controller='Member' action='SaveSetup' }}" method="post">
                    <table>
                        <tr>
                            <td width="32%">
                                <p>
                                    <label for="default_points">会员默认积分:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                        <input style="width: 32%;" class="itext" id="default_points" name="default_points" value="{{ $default_points.value }}" />
                                    </b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td width="32%">
                                <p>
                                    <label for="add_points_length">一般评价加分量:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                        <input style="width: 32%;" class="itext" id="add_points_length" name="add_points_length" value="{{ $add_points_length.value }}" />
                                    </b></b>
                                    <small>一次对一般服务进行评价所获得的积分量</small>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td width="32%">
                                <p>
                                    <label for="special_add_points_length">特殊评价加分量:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                        <input style="width: 32%;" class="itext" id="special_add_points_length" name="special_add_points_length" value="{{ $special_add_points_length.value }}" />
                                    </b></b>
                                    <small>一次对特殊服务进行评价所获得的积分量</small>
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
