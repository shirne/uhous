{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ if $business.business_id }}

    {{ assign var='label' value='编辑行业' }}

{{ else }}

    {{ assign var='label' value='添加行业' }}

{{ /if }}

{{ webcontrol type='Position' name='position' column='栏目管理' position=$label footprint='yes' }}

{{ assign var='cmdType' value='business' }}

{{ include file='modules/merchant/cmd.tpl' }}

<div class="layout clearfix">

        <div class="box">
            <h3>{{$label}}</h3>
            <div class="form">

                <form id="editform" name="editform" action="{{ url controller='Merchant' action='SaveBusiness' }}" method="post"  enctype="multipart/form-data">
                    <table>
                        <tr>
                            <td>
                                <p>
                                    <label for="name">行业:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="name" name="name" value="{{$business.name}}" /></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <input class="ibtn ibtn-ok" type="submit" value="保存" />
                                    <input id="business_id" name="business_id" type="hidden" value="{{$business.business_id}}" />
                                    <input id="col_key" name="col_key" type="hidden" value="{{$business.col_key}}" />
                                    <input id="lang" name="lang" type="hidden" value="{{$business.lang}}" />
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
