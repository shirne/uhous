{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='栏目管理' position='上传副图' footprint='yes' }}

{{ assign var='cmdType' value='products' }}

{{ include file='modules/products/cmd.tpl' }}

<div class="layout clearfix">

        <div class="box">
            <h3>[{{$product.name}}] 上传副图</h3>
            <div class="form">

                <form id="editform" name="editform" action="{{ url controller='Products' action='SavePhoto' }}" method="post" enctype="multipart/form-data">
                    <table>
                        <tr>
                            <td style="width: 45%;">
                                <p>
                                    <label for="name">副图名称:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="name" name="name" value="{{$photo.name}}"{{ if $upload == 'no' }} readonly="readonly"{{ /if }} /></b></b>
                                    <small>可选填写。</small>
                                </p>
                            </td>
                            <td style="width: 5%;"></td>
                            <td style="width: 50%;">
                                <p>
                                    <label for="pic">上传图片:</label>
{{ if $photo.pic }}
                                    <div>
                                        <img src="/{{ get_app_inf key='uploadDir' }}thumb_{{$photo.pic}}" height="32" />
                                        <a href="/{{ get_app_inf key='uploadDir' }}{{$photo.pic}}" target="_blank">查看原图</a> | <a href="{{ url controller='Products' action='RemovePhotoPic' id=$product.pro_id photo_id=$photo.photo_id }}">删除图片</a>
                                    </div>
                                    <small>如需要重新上传图片，须先删除图片。</small>
{{ else }}
{{ if $upload != 'no' }}
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="file" id="pic" name="pic" /></b></b>
                                    <small>图片尺寸：500px X 375px (像素)</small>
{{ else }}
                                    <small>只允许上传4张副图。</small>
{{ /if }}
{{ /if }}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <p>
{{ if $upload != 'no' }}
                                    <input class="ibtn ibtn-ok" type="submit" value="保存" />
{{ /if }}
                                    <input id="pro_id" name="pro_id" type="hidden" value="{{$product.pro_id}}" />
                                    <input id="photo_id" name="photo_id" type="hidden" value="{{$photo.photo_id}}" />
                                    <input id="col_key" name="col_key" type="hidden" value="{{$product.col_key}}" />
                                    <input id="lang" name="lang" type="hidden" value="{{$product.lang}}" />
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <p>
                                    <fieldset class="fold">
                                        <legend>副图列表</legend>
                                        <div>
                                            <ul class="inline-list clearfix">
{{ foreach from=$product.photos item=photo }}
                                                <li><img src="/{{ get_app_inf key='uploadDir' }}thumb_{{$photo.pic}}" height="160" /><a href="{{ url controller='Products' action='Photos' id=$product.pro_id photo_id=$photo.photo_id }}">修改</a> | <a href="{{ url controller='Products' action='RemovePhoto' id=$product.pro_id photo_id=$photo.photo_id }}">删除</a></li>
{{ /foreach }}
                                            </ul>
                                        </div>
                                    </fieldset>
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

