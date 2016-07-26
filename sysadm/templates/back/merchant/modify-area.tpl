{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ if $area.merc_id }}

    {{ assign var='label' value='编辑区域' }}

{{ else }}

    {{ assign var='label' value='添加区域' }}

{{ /if }}

{{ webcontrol type='Position' name='position' column='栏目管理' position=$label footprint='yes' }}

{{ assign var='cmdType' value='area' }}

{{ include file='modules/merchant/cmd.tpl' }}

<div class="layout clearfix">

        <div class="box">
            <h3>{{$label}}</h3>
            <div class="form">

                <form id="editform" name="editform" action="{{ url controller='Merchant' action='SaveArea' }}" method="post"  enctype="multipart/form-data">
                    <table>
                        <tr>
                            <td>
                                <p>
                                    <label for="parent_id">所属区域:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <select id="parent_id" name="parent_id">
{{ foreach from=$areas item=value }}
                                        <option value="{{$value.cate_id}}"{{ if $area.parent_id == $value.cate_id }} selected="selected"{{ /if }}>{{$value.name}}</option>
{{ /foreach }}
                                    </select>
                                    </b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="name">区域名称:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="name" name="name" value="{{$area.name}}" /></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <input class="ibtn ibtn-ok" type="submit" value="保存" />
                                    <input id="cate_id" name="cate_id" type="hidden" value="{{$area.cate_id}}" />
                                    <input id="col_key" name="col_key" type="hidden" value="{{$col_key}}" />
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
