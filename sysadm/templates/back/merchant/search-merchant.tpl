{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='栏目管理' position='搜索商家' footprint='yes' }}

{{ assign var='cmdType' value='merchant' }}

{{ include file='modules/merchant/cmd.tpl' }}

<div class="layout clearfix">

        <div class="box">
            <h3>搜索商家</h3>
            <div class="form">
                <form id="editform" name="editform" action="{{ url controller='Merchant' search='yes' }}" method="post">
                    <table>
                        <tr>
                            <td width="20%">
                                <p style="padding-top:1px;">
                                    <label for="business_id">所属行业:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <select id="business_id" name="business_id">
                                        <option value="0">所有行业</option>
{{ foreach from=$business item='value' }}
    <option value="{{ $value.business_id }}">{{ $value.name }}</option>
{{ /foreach }}
                                    </select>
                                    </b></b>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <label for="cate_id">所属分类:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <!--行业下的一级分类-->
                                    <span id="categories-zone">
                                    <select id="cate_id" name="cate_id" disabled="disabled">
                                        <option value="0">所有分类</option>
                                    </select>
                                    </span>
                                    <!--区域子分类-->
                                    <span id="subcategories-zone"></span>
                                    </b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p style="padding-top:1px;">
                                    <label for="area">所属区域:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <select id="area" name="area" style="padding-top:1px;">
                                        <option value="0">所有区域</option>
{{ foreach from=$areas item=value }}
                                        <option value="{{$value.cate_id}}">{{$value.name}}</option>
{{ /foreach }}
                                    </select>

                                    <!--区域子分类-->
                                    <span id="area-zone"></span>
                                    </b></b>
                                </p>
                            </td>
                            <td>
                                <p style="padding-top:1px;">
                                    <!--街道分类-->
                                    <label for="street_id">所属街道:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <span id="street-zone">
                                    <select id="street_id" name="street_id"  disabled="disabled"> 
                                        <option value="0">所有街道</option>
                                    </select>
                                    </span>
                                    </b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <p>
                                    <label for="name">商家名称:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="name" name="name" value="" /></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <p>
                                    <input class="ibtn ibtn-ok" type="submit" value="开始搜索" />
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
         * 选择分类 
         */
        $('#business_id').change(function(){

            $.get('{{ url controller='Merchant' action='SelectBusiness' }}&addtype=search&business=' + $('#business_id option:selected').attr('value'), function(data){
                if (data) {
                    $('#categories-zone').html(data);
                }
            });

            $.get('{{ url controller='Merchant' action='SelectCategory' }}&addtype=search&business=' + $('#business_id option:selected').attr('value'), function(data){
            if (data) {
                $('#subcategories-zone').html(data);
                }
            });

        });

        $('#categories-zone').change(function(){
            $.get('{{ url controller='Merchant' action='SelectCategory' }}&addtype=search&business_id=' + $('#cate_id option:selected').attr('value') + '&cate_id=' + $('#cate_id option:selected').attr('value'), function(data){
            if (data) {
                $('#subcategories-zone').html(data);
                }
            });
        });
        /**
         * 选择区域 
         */
        $('#area').change(function(){

            $.get('{{ url controller='Merchant' action='SelectSubArea' }}&addtype=merchant&parent_area=' + $('#area option:selected').attr('value'), function(data){
                if (data) {
                    $('#area-zone').html(data);
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
        $('#area-zone').change(function(){
            $.get('{{ url controller='Merchant' action='SelectStreet' }}&addtype=merchant&parent_area=' + $('#subarea option:selected').attr('value') + '&sub_area=' + $('#area-zone option:selected').attr('value'), function(data){
                if (data) {
                    $('#street-zone').html(data);
                }
             });
        });
    });
</script>

</body>

</html>
