{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ if $street.merc_id }}

    {{ assign var='label' value='编辑街道' }}

{{ else }}

    {{ assign var='label' value='添加街道' }}

{{ /if }}

{{ webcontrol type='Position' name='position' column='栏目管理' position=$label footprint='yes' }}

{{ assign var='cmdType' value='street' }}

{{ include file='modules/merchant/cmd.tpl' }}

<div class="layout clearfix">

        <div class="box">
            <h3>{{$label}}</h3>
            <div class="form">

                <form id="editform" name="editform" action="{{ url controller='Merchant' action='SaveStreet' }}" method="post"  enctype="multipart/form-data">
                    <table>
                        <tr>
                            <td>
                                <p>
                                    <label for="cate_id">所属区域:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <select id="cate_id" name="cate_id">
{{ foreach from=$areas item=area }}
{{ if $area.children }}
    <optgroup label="{{$area.name}}">
    {{ foreach from=$area.children item=child }}
        <option value="{{$child.cate_id}}"{{ if $street.cate_id == $child.cate_id }} selected="selected"{{ /if }}>{{$child.name}}</option>
    {{ /foreach }}
    </optgroup>
{{ else }}
    <option value="{{$area.cate_id}}"{{ if $street.cate_id == $area.cate_id }} selected="selected"{{ /if }}>{{$area.name}}</option>
{{ /if }}
{{ /foreach }}
                                    </select>
                                    </b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="name">街道名称:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="name" name="name" value="{{$street.name}}" /></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <input class="ibtn ibtn-ok" type="submit" value="保存" />
                                    <input id="street_id" name="street_id" type="hidden" value="{{$street.street_id}}" />
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
