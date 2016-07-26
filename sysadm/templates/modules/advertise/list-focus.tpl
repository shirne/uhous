{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='栏目管理' position='焦点图列表' footprint='yes' }}

{{ assign var='cmdType' value='focus' }}

{{ include file='modules/advertise/cmd.tpl' }}

<div class="layout clearfix">

        <div class="box">
            <h3>上传焦点图</h3>
            <div class="form">

                <form id="editform" name="editform" action="{{ url controller='Advertise' action='Save' }}" method="post" enctype="multipart/form-data">
                    <table>
                        <tr>
                            <td style="width: 45%;">
                                <p>
                                    <label for="title">广告标题:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="title" name="title" value="{{ $advertise.title }}"{{ if $upload == 'no' }} readonly="readonly"{{ /if }} /></b></b>
                                </p>
                            </td>
                            <td style="width: 5%;"></td>
                            <td style="width: 20%;">
                                <p>
                                    <label for="pic">上传图片:</label>
                                    {{ if $advertise.pic }}
                                    <div>
                                        <img src="/{{ get_app_inf key='uploadDir' }}{{ $advertise.pic }}" height="32" />
                                        <a href="/{{ get_app_inf key='uploadDir' }}{{ $advertise.pic }}" target="_blank">查看原图</a> | <a href="{{ url controller='Advertise' action='RemovePic' id=$advertise.adv_id type="Focus" }}">删除图片</a>
                                    </div>
                                    <small>如需要重新上传图片，须先删除图片。</small>
                                    {{ else }}
                                        {{ if $upload != 'no' }}
                                        <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="file" id="pic" name="pic" /></b></b>
                                        <small>图片尺寸：923px X 356px (像素)</small>
                                        {{ else }}
                                        <small>只允许上传5张焦点图。</small>
                                        {{ /if }}
                                    {{ /if }}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 45%;">
                                <p>
                                    <label for="url">广告链接:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="url" name="url" value="{{ $advertise.url }}"{{ if $upload == 'no' }} readonly="readonly"{{ /if }} /></b></b>
                                </p>
                            </td>
                            <td style="width: 5%;"></td>
                            <td style="width: 10%;">
                                <p>
                                    <label for="sort">显示顺序:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="sort" name="sort_id" value="{{ $advertise.sort_id }}"{{ if $upload == 'no' }} readonly="readonly"{{ /if }} /></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <p>
                                    {{ if $upload != 'no' }}
                                    <input class="ibtn ibtn-ok" type="submit" value="保存" />
                                    {{ /if }}
                                    <input id="adv_id" name="adv_id" type="hidden" value="{{ $advertise.adv_id }}" />
                                    <input id="col_key" name="col_key" type="hidden" value="{{ $advertise.col_key }}" />
                                    <input id="lang" name="lang" type="hidden" value="{{ $advertise.lang }}" />
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <p>
                                    <fieldset class="fold">
                                        <legend>焦点图列表</legend>
                                        <div>
                                            <ul class="clearfix">
                                                {{ foreach from=$advertises item=advertise }}
                                                <li>
                                                    <img src="/{{ get_app_inf key='uploadDir' }}{{ $advertise.pic }}" width="360px" />
                                                    <a href="{{ url controller='Advertise' action='Modify' type='Focus' id=$advertise.adv_id }}">修改</a> | 
                                                    <a href="{{ url controller='Advertise' action='Remove' type='Focus' id=$advertise.adv_id }}">删除</a>
                                                </li>
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
