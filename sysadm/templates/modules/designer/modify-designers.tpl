{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ if $desmation.des_id }}

    {{ assign var='label' value='编辑设计师' }}

{{ else }}

    {{ assign var='label' value='添加设计师' }}

{{ /if }}

{{ webcontrol type='Position' name='position' column='栏目管理' position=$label footprint='yes' }}

{{ include file='modules/designer/cmd.tpl' }}

<div class="layout clearfix">

        <div class="box">
            <h3>{{$label}}</h3>
            <div class="form">

                <form id="editform" name="editform" action="{{ url controller='Designer' action='Save' }}" method="post" enctype="multipart/form-data">
                    <table>
                        <tr>
                            <td width="35%">
                                <p>
                                    <label for="name">设计师名称:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="name" name="name" value="{{$designer.name}}" /></b></b>
                                </p>
                            </td>
                            <td width="5%"></td>
                            <td width="35%">
                                <p>
                                    <label for="style">设计风格:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="style" name="style" value="{{$designer.style}}" /></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="photo">设计师头像:</label>
{{ if $designer.photo }}
                                    <div>
                                        <img src="/{{ get_app_inf key='uploadDir' }}{{$designer.photo}}" height="32" />
                                        <a href="/{{ get_app_inf key='uploadDir' }}{{$designer.photo}}" target="_blank">查看原图</a> | <a href="{{ url controller='Designer' action='RemovePhoto' id=$designer.des_id }}">删除图片</a>
                                    </div>
                                    <small>如需要重新上传图片，须先删除图片。</small>
{{ else }}
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="file" id="photo" name="photo" /></b></b>
{{ /if }}
                                </p>
                            </td>
                            <td width="5%"></td>
                            <td>
                                <p>
                                    <label for="pic">设计风格例图:</label>
{{ if $designer.pic }}
                                    <div>
                                        <img src="/{{ get_app_inf key='uploadDir' }}{{$designer.pic}}" height="32" />
                                        <a href="/{{ get_app_inf key='uploadDir' }}{{$designer.pic}}" target="_blank">查看原图</a> | <a href="{{ url controller='Designer' action='RemovePic' id=$designer.des_id }}">删除图片</a>
                                    </div>
                                    <small>如需要重新上传图片，须先删除图片。</small>
{{ else }}
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="file" id="pic" name="pic" /></b></b>
{{ /if }}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <p>
                                    <label for="profile">设计简介:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                        {{ webcontrol type='Editor' name='profile' value=$designer.profile height="200" }}
                                    </b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <input class="ibtn ibtn-ok" type="submit" value="保存" />
                                    <input id="des_id" name="des_id" type="hidden" value="{{$designer.des_id}}" />
                                    <input id="col_key" name="col_key" type="hidden" value="{{$designer.col_key}}" />
                                    <input id="lang" name="lang" type="hidden" value="{{$designer.lang}}" />
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

