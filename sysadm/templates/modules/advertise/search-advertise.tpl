{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='栏目管理' position='搜索广告' footprint='yes' }}

{{ include file='modules/advertise/cmd.tpl' }}

<div class="layout clearfix">

        <div class="box">
            <h3>搜索广告</h3>
            <div class="form">

                <form id="editform" name="editform" action="{{ url controller='Advertise' search='yes' }}" method="post">
                    <table>
                        <tr>
                            <td>
                                <p>
                                    <label for="name">广告标题:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="title" name="title" value="" /></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <p>
                                    <input class="ibtn ibtn-ok" type="submit" value="开始搜索" />
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
