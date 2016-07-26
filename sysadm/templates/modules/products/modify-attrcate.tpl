{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ if $category.cate_id }}

    {{ assign var='label' value='编辑属性项' }}

{{ else }}

    {{ assign var='label' value='添加属性项' }}

{{ /if }}

{{ webcontrol type='Position' name='position' column='栏目管理' position=$label footprint='yes' }}

{{ assign var='cmdType' value='attribute' }}

{{ include file='modules/products/cmd.tpl' }}

<div class="layout clearfix">

        <div class="box">
            <h3>{{$label}}</h3>
            <div class="form">

                <form id="editform" name="editform" action="{{ url controller='Products' action='SaveAttrCate' }}" method="post">
                    <table>
                        <tr>
                            <td>
                                <p>
                                    <label for="parent_id">所属属性项:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <select id="parent_id" name="parent_id">
                                        <option value="0">作为一级属性项</option>
                                    </select>
                                    </b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="name">属性项名称:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="name" name="name" value="{{$category.name}}" /></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <input class="ibtn ibtn-ok" type="submit" value="保存" />
                                    <input id="cate_id" name="cate_id" type="hidden" value="{{$category.cate_id}}" />
                                    <input id="col_key" name="col_key" type="hidden" value="{{$category.col_key}}" />
                                    <input id="lang" name="lang" type="hidden" value="{{$category.lang}}" />
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

