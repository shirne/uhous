{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ if $brand.brand_id }}

    {{ assign var='label' value='编辑品牌' }}

{{ else }}

    {{ assign var='label' value='添加品牌' }}

{{ /if }}

{{ webcontrol type='Position' name='position' column='栏目管理' position=$label footprint='yes' }}

{{ assign var='cmdType' value='brands' }}

{{ include file='modules/products/cmd.tpl' }}

<div class="layout clearfix">

        <div class="box">
            <h3>{{$label}}</h3>
            <div class="form">

                <form id="editform" name="editform" action="{{ url controller='Products' action='SaveBrand' }}" method="post" enctype="multipart/form-data">
                    <table>
                        <tr>
                            <td  >
                                <p>
                                    <label for="name">品牌名称:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="name" name="name" value="{{$brand.name}}" /></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td  >
                                <p>
                                    <label for="link">链接:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="link" name="link" value="{{$brand.link}}" /></b></b>
                                    <small>请填写完整的链接，如："http://www.xxx.com"</small>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <input name='memo[title]' value="{{ if $brand.memo.title}}{{$brand.memo.title}} {{else}}品牌介绍{{/if}}" style="border: 0; background: white; font-size: 12px; height: 25px; line-height:25px;" />
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='editor' name='memo[content]' value=$brand.memo.content class='itext' height="150" }}</b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <input name='intro[1][title]' value="{{ if $brand.intro.1.title}}{{$brand.intro.1.title}} {{else}}完美制造{{/if}}" style="border: 0; background: white; font-size: 12px; height: 25px; line-height:25px;" />
                                    <b class="fluid-input"><b class="fluid-input-inner"><textarea name="intro[1][content]" style="width:100%;height:60px">{{$brand.intro.1.content}}</textarea></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <input name='intro[2][title]' value="{{ if $brand.intro.2.title}}{{$brand.intro.2.title}} {{else}}设计风格{{/if}}" style="border: 0; background: white; font-size: 12px; height: 25px; line-height:25px;" />
                                    <b class="fluid-input"><b class="fluid-input-inner"><textarea name="intro[2][content]" style="width:100%;height:60px">{{$brand.intro.2.content}}</textarea></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <input name='intro[3][title]' value="{{ if $brand.intro.3.title}}{{$brand.intro.3.title}} {{else}}豪华舒适{{/if}}" style="border: 0; background: white; font-size: 12px; height: 25px; line-height:25px;" />
                                    <b class="fluid-input"><b class="fluid-input-inner"><textarea name="intro[3][content]" style="width:100%;height:60px">{{$brand.intro.3.content}}</textarea></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <input name='intro[4][title]' value="{{ if $brand.intro.4.title}}{{$brand.intro.4.title}} {{else}}社会荣誉{{/if}}" style="border: 0; background: white; font-size: 12px; height: 25px; line-height:25px;" />
                                    <b class="fluid-input"><b class="fluid-input-inner"><textarea name="intro[4][content]" style="width:100%;height:60px">{{$brand.intro.4.content}}</textarea></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="pic">品牌图片(大):</label>
{{ if $brand.pic }}
                                    <div>
                                        <img src="/{{ get_app_inf key='uploadDir' }}{{$brand.pic}}" height="32" />
                                        <a href="/{{ get_app_inf key='uploadDir' }}{{$brand.pic}}" target="_blank">查看原图</a> | <a href="{{ url controller='Products' action='RemoveBrandPic' id=$brand.brand_id witch='pic' }}">删除图片</a>
                                    </div>
                                    <small>如需要重新上传图片，须先删除图片。</small>
{{ else }}
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="file" id="pic" name="pic" /></b></b>
                                    <small>建议图片尺寸：960px X 279px (像素)</small>
{{ /if }}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="minpic">品牌图片(小):</label>
{{ if $brand.minpic }}
                                    <div>
                                        <img src="/{{ get_app_inf key='uploadDir' }}{{$brand.minpic}}" height="32" />
                                        <a href="/{{ get_app_inf key='uploadDir' }}{{$brand.minpic}}" target="_blank">查看原图</a> | <a href="{{ url controller='Products' action='RemoveBrandPic' id=$brand.brand_id witch='minpic' }}">删除图片</a>
                                    </div>
                                    <small>如需要重新上传图片，须先删除图片。</small>
{{ else }}
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="file" id="minpic" name="minpic" /></b></b>
                                    <small>建议图片尺寸：250px X 188px (像素)</small>
{{ /if }}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="minpic">品牌LOGO:</label>
{{ if $brand.logo }}
                                    <div>
                                        <img src="/{{ get_app_inf key='uploadDir' }}{{$brand.logo}}" height="32" />
                                        <a href="/{{ get_app_inf key='uploadDir' }}{{$brand.logo}}" target="_blank">查看原图</a> | <a href="{{ url controller='Products' action='RemoveBrandPic' id=$brand.brand_id witch='logo' }}">删除图片</a>
                                    </div>
                                    <small>如需要重新上传图片，须先删除图片。</small>
{{ else }}
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="file" id="logo" name="logo" /></b></b>
                                    <small>建议图片尺寸：120px X 120px (像素)</small>
{{ /if }}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <input class="ibtn ibtn-ok" type="submit" value="保存" />
                                    <input id="brand_id" name="brand_id" type="hidden" value="{{$brand.brand_id}}" />
                                    <input id="col_key" name="col_key" type="hidden" value="{{$brand.col_key}}" />
                                    <input id="lang" name="lang" type="hidden" value="{{$brand.lang}}" />
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

