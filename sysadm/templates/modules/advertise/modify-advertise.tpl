{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ if $advertise.adv_id }}

    {{ assign var='label' value='编辑广告' }}

{{ else }}

    {{ assign var='label' value='添加广告' }}

{{ /if }}

{{ webcontrol type='Position' name='position' column='栏目管理' position=$label footprint='yes' }}

{{ include file='modules/advertise/cmd.tpl' }}

    <div class="layout clearfix">

        <div class="box">
            <h3>{{ $label }}</h3>
            <div class="form">
            <form id="editform" name="editform" action="{{ url controller='Advertise' action='Save' }}" method="post"  enctype="multipart/form-data">
                <table>
                    <tr>
                        <td>
                            <p>
                                <label for="title">广告标题:</label>
                                <b class="fluid-input"><b class="fluid-input-inner">
                                <input class="itext" type="text" id="title" name="title" value="{{ $advertise.title }}" />
                                </b></b>
                            </p>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <p>
                                <label for="url">广告链接:</label>
                                <b class="fluid-input"><b class="fluid-input-inner">
                                <input class="itext" type="text" id="url" name="url" value="{{ $advertise.url }}" />
                                </b></b>
                            </p>
                        </td>
                        <td></td>
                    </tr>
                        <tr>
                            <td colspan="3">
                                <p>
                                    <label for="pic">商品图片:</label>
                                    {{ if $advertise.pic }}

                                    <div>
                                        <img src="/{{ get_app_inf key='uploadDir' }}{{ $advertise.pic }}" height="32" />
                                        <a href="/{{ get_app_inf key='uploadDir' }}{{ $advertise.pic }}" target="_blank">查看原图</a> | <a href="{{ url controller='Advertise' action='RemovePic' id=$advertise.adv_id }}">删除图片</a>
                                    </div>
                                    <small>如需要重新上传图片，须先删除图片。</small>

                                    {{ else }}

                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="file" id="pic" name="pic" /></b></b>
                                    <small>图片尺寸：220px X 80px (像素)。</small>

                                    {{ /if }}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <p>
                                    <input class="ibtn ibtn-ok" type="submit" value="保存" />
                                    <input id="adv_id" name="adv_id" type="hidden" value=" {{ $advertise.adv_id }} " />
                                    <input id="col_key" name="col_key" type="hidden" value="{{ $advertise.col_key}}" />
                                    <input id="lang" name="lang" type="hidden" value="{{ $advertise.lang }}" />
                                </p>
                            </td>
                        </tr>

                </table>
            </form>
            </div>
        </div>

    </div>

</div>

</body>

</html>
