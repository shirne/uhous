{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ if $merchant.merc_id }}

    {{ assign var='label' value='编辑商家' }}

{{ else }}

    {{ assign var='label' value='添加商家' }}

{{ /if }}

{{ webcontrol type='Position' name='position' column='栏目管理' position=$label footprint='yes' }}

{{ assign var='cmdType' value='merchant' }}

{{ include file='modules/merchant/cmd.tpl' }}

<div class="layout clearfix">

        <div class="box">
            <h3>{{$label}}</h3>
            <div class="form">

                <form id="editform" name="editform" action="{{ url controller='Merchant' action='Save' }}" method="post"  enctype="multipart/form-data">
                    <table>
                        {{ if $merchant.merc_id }}
                        <tr>
                            <td colspan="2">
                                <a class="btn btn-base fl" href="{{ url controller='Merchant' action="Foods" merc_id=$merchant.merc_id }}">美食管理</a>
                            </td>
                            <td><td>
                        </tr>
                        {{ /if }}
                        <tr>
                             <td width="45%">
                                <p>
                                    <span>
                                    <label for="business_id">所属行业:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <select id="business_id" name="business_id">
                                        <option value="0">请选择行业</option>
{{ foreach from=$business item='value' }}
    <option value="{{ $value.business_id }}" {{ if $merchant.category.business_id eq $value.business_id }}selected="selected"{{ /if }} {{ if !$value.category }}disabled="disabled" style="font-style: italic;"{{ /if }}>{{ $value.name }}</option>
{{ /foreach }}
                                    </select>
                                    </b></b>
                                    </span>
                                </p>
                            </td>                       
                            <td width="2%"></td>
                            <td>
                                <p>
                                    <label for="area">所属区域:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <select id="area" name="area">
                                        <option value="0">请选择区域</option>
{{ foreach from=$areas item='area' }}
    <option value="{{ $area.cate_id }}" {{ if $area.cate_id eq $merchant.street.parent_id }}selected="selected"{{ /if }}>{{ $area.name }}</option>
{{ /foreach }}
                                    </select>
                                    <span id="subarea-zone"></span>
                                    </b></b>
                                </p>
                            </td>   
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="cate_id">所属分类:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <span id="categories-zone">
                                        <select disabled="disabled">
                                            <option>请选择分类</option>
                                        </select>
                                    </span>
                                    <span id="subcategory-zone"></span>
                                    </b></b>
                                </p>
                            </td>
                            <td></td>
                            <td>
                                <p>
                                    <label for="street_id">所属街道:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <span id="street-zone">
                                        <select disabled="disabled">
                                            <option>请选择街道</option>
                                        </select>
                                    </span>
                                    </b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="name">商家名称:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='textbox' name='name' value=$merchant.name class='itext' }}</b></b>
                                </p>
                            </td>
                            <td width="2%"></td>
                            <td>
                                <p>
                                    <label for="clicktimes">点击量:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='textbox' name='clicktimes' value=$merchant.clicktimes class='itext' }}</b></b>
                                </p>
                            </td>
                            <td width="2%"></td>
                            <td>
                                <p>
                                    <label for="phone">联系电话:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='textbox' name='phone' value=$merchant.phone class='itext' }}</b></b>
                                </p>
                            </td>
                            <td width="2%"></td>
                            <td>
                                <p>
                                    <label for="time">营业时间:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='textbox' name='time' value=$merchant.time class='itext' }}</b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7">
                                <p>
                                    <label for="address">联系地址:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='textbox' name='address' value=$merchant.address class='itext' }}</b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="logos">商家图片/商标:</label>
{{ if $merchant.logo }}
                                    <div>
                                        <img src="/{{ get_app_inf key='uploadDir' }}{{$merchant.logo}}" height="32" />
                                        <a href="/{{ get_app_inf key='uploadDir' }}{{$merchant.logo}}" target="_blank">查看原图</a> | <a href="{{ url controller='Merchant' action='RemoveLogo' id=$merchant.merc_id }}">删除图片</a>
                                    </div>
                                    <small>如需要重新上传图片，须先删除图片。</small>
{{ else }}
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="file" id="logos" name="logo" /></b></b>
                                    <small>图片尺寸：360px X 360px (像素)。</small>
{{ /if }}
                                </p>
                            </td>
                            <td></td>
                            <td colspan="2">
                                <p>
                                    <label for="pic">商家地图:</label>
{{ if $merchant.pic }}
                                    <div>
                                        <img src="/{{ get_app_inf key='uploadDir' }}{{$merchant.pic}}" height="32" />
                                        <a href="/{{ get_app_inf key='uploadDir' }}{{$merchant.pic}}" target="_blank">查看原图</a> | <a href="{{ url controller='Merchant' action='RemovePic' id=$merchant.merc_id }}">删除图片</a>
                                    </div>
                                    <small>如需要重新上传图片，须先删除图片。</small>
{{ else }}
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="file" id="pic" name="pic" /></b></b>
                                    <small>图片尺寸：360px X 360px (像素)。</small>
{{ /if }}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7">
                                <p>
                                    <label for="post">商家公告:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    {{ webcontrol type='Editor' name='post' value=$merchant.post style='Basic' height='120' }}
                                    </b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <p>
                                    <input class="ibtn ibtn-ok" type="submit" value="保存" />
                                    <input id="merc_id" name="merc_id" type="hidden" value="{{$merchant.merc_id}}" />
                                    <input id="col_key" name="col_key" type="hidden" value="{{$merchant.col_key}}" />
                                    <input id="lang" name="lang" type="hidden" value="{{$merchant.lang}}" />
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

<script type="text/javascript">
    $(document).ready(function(){
        /**
         *  选择行业
         */
        $('#business_id').change(function(){
            $.get('{{ url controller='Merchant' action='SelectBusiness' }}&addtype=merchant&business=' + $('#business_id option:selected').attr('value'), function(data){
                if (data) {
                    $('#categories-zone').html(data);
                }
            });

            $.get('{{ url controller='Merchant' action='SelectCategory' }}&addtype=merchant&business=' + $('#business_id option:selected').attr('value'), function(data){
                if (data) {
                    $('#subcategory-zone').html(data);
                }
            });
        });
        /**
         * 选择分类 
         */
        $('#categories-zone').change(function(){
            $.get('{{ url controller='Merchant' action='SelectCategory' }}&addtype=merchant&business=' + $('#business_id option:selected').attr('value') + '&cate_id=' + $('#categories-zone option:selected').attr('value'), function(data){
                if (data) {
                    $('#subcategory-zone').html(data);
                }
            });
        });
        /**
         * 选择区域
         * --------------------------------------------------------------
         */
        $('#area').change(function(){

            $.get('{{ url controller='Merchant' action='SelectSubArea' }}&addtype=merchant&parent_area=' + $('#area option:selected').attr('value'), function(data){
                if (data) {
                    $('#subarea-zone').html(data);
                }
            });
            $.get('{{ url controller='Merchant' action='SelectStreet' }}&addtype=merchant&parent_area=' + $('#subarea option:selected').attr('value'), function(data){
            if (data) {
                $('#street-zone').html(data);
                }
            });
        });
        /**
         * 选择子区域
         */
        $('#subarea-zone').change(function(){
            $.get('{{ url controller='Merchant' action='SelectStreet' }}&addtype=merchant&parent_area=' + $('#subarea option:selected').attr('value') + '&sub_area=' + $('#subarea-zone option:selected').attr('value'), function(data){
                if (data) {
                    $('#street-zone').html(data);
                }
             });
        });


    });


</script>

<!--编辑商家时调用-->
{{ if $merchant }}
<script type="text/javascript">
    $(document).ready(function(){
        /**
         * 选择分类--编辑商家
         */
        $.get('{{ url controller='Merchant' action='SelectBusiness' }}&addtype=merchant&business=' + {{ $merchant.category.business_id }} + '&parent_id={{ $merchant.category.parent_id }}', function(data){
            if (data) {
                $('#categories-zone').html(data);
            }
        });
        $.get('{{ url controller='Merchant' action='SelectCategory' }}&addtype=merchant&business=' + {{ $merchant.category.business_id }} +  '&cate_id={{ $merchant.category.parent_id }}&sub_id=' + {{ $merchant.cate_id }}, function(data){
            if (data) {
                $('#subcategory-zone').html(data);
            }
        });
        /**
         * 选择区域--编辑商家 
         */
        $.get('{{ url controller='Merchant' action='SelectSubArea' }}&addtype=merchant&parent_area={{ $merchant.street.parent_id }}&sub_area={{ $merchant.street.cate_id }}', function(data){
            if (data) {
                $('#subarea-zone').html(data);
            }
        });
        /**
         * 选择子区域--编辑商家执行 
         */
        $.get('{{ url controller='Merchant' action='SelectStreet' }}&addtype=merchant&parent_area={{ $merchant.street.paretn_id }}&sub_area={{ $merchant.street.cate_id }}&street_id={{ $merchant.street_id }}', function(data){
            if (data) {
                $('#street-zone').html(data);
            }
        });

    });
</script>
{{ /if }}


</body>

</html>
