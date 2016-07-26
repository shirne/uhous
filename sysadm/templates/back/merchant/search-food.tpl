{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='栏目管理' position='搜索服务项' footprint='yes' }}

{{ assign var='cmdType' value='foods' }}

{{ include file='modules/merchant/cmd.tpl' }}

<div class="layout clearfix">

        <div class="box" style="width: 22%; float: left; margin-right: 2%;">
            <h3><a class="btn btn-small-base fr" style="padding: 0px 4px; text-indent:0px; margin: 5px 10px 0 0; font-weight: normal;" href="{{ url controller='Merchant' action='Modify' merc_id=$merchantInfo.merc_id }}">编辑</a>{{ $merchantInfo.name }}</h3>
            <div class="form">
            <table>
                <tr>
                    <td colspan="2" class="tc" >
                        <p>
                            <b class="fluid-input"><b class="fluid-input-inner">
                            <img src="/{{ get_app_inf key='uploadDir' }}{{ $merchantInfo.logo }}" width="160px;" />
                            </b></b>
                        </p>
                    </td>
                </tr>
                <tr><td width="30%;" valign="top">联系电话：</td><td>{{ $merchantInfo.phone }}</td></tr>
                <tr><td width="30%;" valign="top">联系地址：</td><td>{{ $merchantInfo.address }}</td></tr>
                <tr>
                    <td colspan="2" class="{{ if $merchantInfo.pic }}tc{{ /if }}">
                        <p>
                            <b class="fluid-input"><b class="fluid-input-inner">
                            <img src="/{{ get_app_inf key='uploadDir' }}{{ $merchantInfo.pic }}" width="160px;" alt="地图" />
                            </b></b>
                        </p>
                    </td>
                </tr>
            </table>
            </div>
        </div>

        <div class="box" style="width: 75%; float: left; ">
            <h3>搜索服务项</h3>
            <div class="form">
                <form id="editform" name="editform" action="{{ url controller='Merchant' action='Foods' merc_id=$smarty.get.merc_id search='yes' }}" method="post">
                    <table>
                        <tr>
                            <td>
                                <p>
                                    <label for="name">服务项名称:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="name" name="name" value="" /></b></b>
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
