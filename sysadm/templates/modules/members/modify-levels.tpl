{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ if $category.cate_id }}

    {{ assign var='label' value='编辑等级' }}

{{ else }}

    {{ assign var='label' value='添加等级' }}

{{ /if }}

{{ webcontrol type='Position' name='position' column='栏目管理' position=$label footprint='yes' }}

{{ assign var='cmdType' value='level' }}

{{ include file='modules/members/cmd.tpl' }}

<div class="layout clearfix">

        <div class="box">
            <h3>{{$label}}</h3>
            <div class="form">

                <form id="editform" name="editform" action="{{ url controller='Member' action='SaveLevel' }}" method="post">
                    <table>
                        <tr>
                            <td>
                                <p>
                                    <label for="name">等级名称:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="levels" name="levels" value="{{$category.levels}}" /></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <input class="ibtn ibtn-ok" type="submit" value="保存" />
                                    <input id="cate_id" name="level_id" type="hidden" value="{{$category.level_id}}" />
                                    <input id="col_key" name="col_key" type="hidden" value="{{$level.col_key}}" />
                                    <input id="lang" name="lang" type="hidden" value="{{$level.lang}}" />
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

