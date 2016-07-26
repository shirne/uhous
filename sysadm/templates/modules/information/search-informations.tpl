{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='栏目管理' position='搜索信息' footprint='yes' }}

{{ include file='modules/information/cmd.tpl' }}

<div class="layout clearfix">

        <div class="box">
            <h3>搜索信息</h3>
            <div class="form">

                <form id="editform" name="editform" action="{{ url controller='Information' search='yes' }}" method="post">
                    <table>
                        <tr>
                            <td>
                                <p>
                                    <label for="title">信息标题:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="title" name="title" value="" /></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="info_id">信息ID:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="info_id" name="info_id" value="" /></b></b>
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

