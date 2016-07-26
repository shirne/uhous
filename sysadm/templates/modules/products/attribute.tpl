{{ include file='layouts/head.tpl' }}
<style type="text/css">
.attSet { margin: 10px 0; }
.attTable { width: 80%; margin: 10px auto; }
    .attTable thead tr td { background: red; }
</style>

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='栏目管理' position='添加属性' footprint='yes' }}

{{ assign var='cmdType' value='attribute' }}

{{ include file='modules/products/cmd.tpl' }}

<div class="layout clearfix">

        <div class="box">
            <h3><a href="{{ url controller='Products' action='Attribute' id=$smarty.get.id }}">[{{$product.name}}] 添加属性</a></h3>
            <div class="form">

                <form id="editform" name="editform" action="{{ url controller='Products' action='SaveAttr' }}" method="post" enctype="multipart/form-data">
                    <table>
                        <tr>
                            <td colspan="3" style="width: 50%;">
                                <p>
                                    <label for="cate_id">所属分类:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <select id="cate_id" name="cate_id">
{{ foreach from=$categories item=cate }}
{{ if $cate.children }}
    <optgroup label="{{$cate.name}}">
    {{ foreach from=$cate.children item=child }}
        <option value="{{$child.cate_id}}"{{ if $attribute.cate_id == $child.cate_id }} selected="selected"{{ /if }}>{{$child.name}}</option>
    {{ /foreach }}
    </optgroup>
{{ else }}
    <option value="{{$cate.cate_id}}"{{ if $attribute.cate_id == $cate.cate_id }} selected="selected"{{ /if }}>{{$cate.name}}</option>
{{ /if }}
{{ /foreach }}
                                    </select>
                                    </b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 45%;">
                                <p>
                                    <label for="name">属性名称:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="name" name="name" value="{{$attribute.name}}"{{ if $upload == 'no' }} readonly="readonly"{{ /if }} /></b></b>
                                </p>
                            </td>
                            <td style="width: 5%;"></td>
                            <td style="width: 50%;">
                                <p>
                                    <label for="pic">上传图片:</label>
{{ if $attribute.pic }}
                                    <div>
                                        <img src="/{{ get_app_inf key='uploadDir' }}{{$attribute.pic}}" height="32" />
                                        <a href="/{{ get_app_inf key='uploadDir' }}{{$attribute.pic}}" target="_blank">查看原图</a> | <a href="{{ url controller='Products' action='RemoveAttrPic' id=$product.pro_id att_id=$attribute.att_id }}">删除图片</a>
                                    </div>
                                    <small>如需要重新上传图片，须先删除图片。</small>
{{ else }}
                                    <div id="uploads">
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="file" id="pic" name="pic" /></b></b>
                                    <small>可选，图片尺寸：940px X 705px (像素)</small>
                                    </div>
                                    <span id="limit" style="display: none;"><small>只允许添4个属性。</small></span>
{{ /if }}
                                </p>
                            </td>
                        </tr>
						<tr>
                            <td colspan="3">
                                <p>
                                    <label for="name">属性内容:</label>
<b class="fluid-input"><b class="fluid-input-inner"><textarea class="itext" id="content" name="content">{{$attribute.content}}</textarea></b></b>                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <p>
                                    <input class="ibtn ibtn-ok" type="submit" value="保存" />
                                    <input id="foreign_id" name="foreign_id" type="hidden" value="{{$product.pro_id}}" />
                                    <input id="att_id" name="att_id" type="hidden" value="{{$attribute.att_id}}" />
                                    <input id="col_key" name="col_key" type="hidden" value="{{$product.col_key}}" />
                                    <input id="lang" name="lang" type="hidden" value="{{$product.lang}}" />
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <p>
                                    <fieldset class="fold">
                                        <legend>属性列表</legend>
                                        <div>
{{ foreach from=$product.attribute item='attr' }}
                                        <fieldset class="attSet fold">
                                            <legend>{{$attr.name}}</legend>
                                            <div>
                                            <table class="attTable table-data">
                                                <thead>
                                                    <th width="10%" class="tc">序号</th>
                                                    <th width="30%" class="tl">属性名称/值</th>
                                                    <th width="40%" class="tl">属性图片</th>
                                                    <th class="tl">操作</th>
                                                </thead>
{{ if $attr.child }}
{{ assign var='count' value=1 }}
{{ foreach from=$attr.child item='pro' }}
                                                <tr>
                                                    <td class="tc">{{$count++}}</td>
                                                    <td>{{$pro.name}}</td>
                                                    <td>{{ if $pro.pic }}<img src="/{{ get_app_inf key='uploadDir' }}thumb_{{$pro.pic}}" height="40" />{{else}}(无){{ /if }}</td>
                                                    <td>
                                                        <a href="{{ url controller='Products' action='Attribute' id=$product.pro_id att_id=$pro.att_id }}">修改</a> | 
                                                        <a href="{{ url controller='Products' action='RemoveAttr' id=$product.pro_id att_id=$pro.att_id }}">删除</a>
                                                    </td>
                                                </tr>
{{ /foreach }}
{{ /if }}
                                            </table>
                                            </div>
                                        </fieldset>
{{ /foreach }}
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

<script type='text/javascript'>
jQuery(function($) {

    $("#cate_id").change(function() {
        $.post(
            "{{ url controller='Products' action='AjaxCheckIsUploadFull' }}",
            {
                pro_id : {{ $product.pro_id }},
                cate_id : $(this).val()
            },
            function(data) {

                if(data.uploads == 'yes') {

                    $("#uploads").show();
                    $("#limit").hide();
                    $("input[type='submit']").show();

                } else {

                    $("#uploads").hide();
                    $("#limit").show();
                    $("input[type='submit']").hide();

                }

            },
            'json'
        );
    });

    $("#cate_id").trigger("change");
});

</script>

</body>

</html>

