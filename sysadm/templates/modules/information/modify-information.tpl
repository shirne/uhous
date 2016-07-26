{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ if $infomation.info_id }}

    {{ assign var='label' value='编辑信息' }}

{{ else }}

    {{ assign var='label' value='发布信息' }}

{{ /if }}

{{ webcontrol type='Position' name='position' column='栏目管理' position=$label footprint='yes' }}

{{ include file='modules/information/cmd.tpl' }}

<div class="layout clearfix">

        <div class="box">
            <h3>{{$label}}</h3>
            <div class="form">

                <form id="editform" name="editform" action="{{ url controller='Information' action='Save' }}" method="post" enctype="multipart/form-data">
                    <table>
                        {{ if $smarty.get.colkey eq 'info' }}
                        <tr>
                           <td style="width: 50%;">
                                <p>
                                    <label for="cate_id">所属分类:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <select id="cate_id" name="cate_id">
{{ foreach from=$categories item=cate }}
{{ if $cate.children }}
    <optgroup label="{{$cate.name}}">
    {{ foreach from=$cate.children item=child }}
        <option value="{{$child.cate_id}}"{{ if $information.cate_id == $child.cate_id }} selected="selected"{{ /if }}>{{$child.name}}</option>
    {{ /foreach }}
    </optgroup>
{{ else }}
    <option value="{{$cate.cate_id}}"{{ if $information.cate_id == $cate.cate_id }} selected="selected"{{ /if }}>{{$cate.name}}</option>
{{ /if }}
{{ /foreach }}
                                    </select>
                                    </b></b>
                                </p>
                            </td>
                        </tr>
                        {{ /if }}
                        <tr>
                            <td>
                                <p>
                                    <label for="title">信息标题:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="title" name="title" value="{{$information.title}}" /></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="pic">信息图片:</label>
{{ if $information.pic }}
                                    <div>
                                        <img src="/{{ get_app_inf key='uploadDir' }}{{$information.pic}}" height="32" />
                                        <a href="/{{ get_app_inf key='uploadDir' }}{{$information.pic}}" target="_blank">查看原图</a> | <a href="{{ url controller='Information' action='RemovePic' id=$information.info_id }}">删除图片</a>
                                    </div>
                                    <small>如需要重新上传图片，须先删除图片。</small>
{{ else }}
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="file" id="pic" name="pic" /></b></b>
{{ /if }}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="content">信息正文:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                        {{ webcontrol type='Editor' name='content' value=$information.content }}
                                    </b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <input class="ibtn ibtn-ok" type="submit" value="保存" />
                                    <input id="info_id" name="info_id" type="hidden" value="{{$information.info_id}}" />
                                    <input id="col_key" name="col_key" type="hidden" value="{{$information.col_key}}" />
                                    <input id="lang" name="lang" type="hidden" value="{{$information.lang}}" />
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

