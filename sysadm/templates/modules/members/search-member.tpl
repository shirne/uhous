{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='栏目管理' position='搜索会员' footprint='yes' }}

{{ assign var='cmdType' value='member' }}

{{ include file='modules/members/cmd.tpl' }}

<div class="layout clearfix">

        <div class="box">
            <h3>搜索会员</h3>
            <div class="form">

                <form id="editform" name="editform" action="{{ url controller='Member' search='yes' }}" method="post">
                    <table>
                        <tr>
                            <td>
                                <p>
                                    <label for="username">会员名称:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="username" name="username" value="" /></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="member_id">会员ID:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="member_id" name="member_id" value="" /></b></b>
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

