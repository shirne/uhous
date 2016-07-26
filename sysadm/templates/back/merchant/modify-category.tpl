{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ if $category.cate_id }}

    {{ assign var='label' value='编辑分类' }}

{{ else }}

    {{ assign var='label' value='添加分类' }}

{{ /if }}

{{ webcontrol type='Position' name='position' column='栏目管理' position=$label footprint='yes' }}

{{ assign var='cmdType' value='categories' }}

{{ include file='modules/merchant/cmd.tpl' }}

<div class="layout clearfix">

        <div class="box">
            <h3>{{$label}}</h3>
            <div class="form">
                <form id="editform" name="editform" action="{{ url controller='Merchant' action='SaveCategory' }}" method="post">
                    <table>
                        <tr>
                            <td>
                                <p>
                                    <label for="type">所属行业:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <select id="business_id" name="business_id">
                                        <option value="0">请选择行业</span>
{{ foreach from=$businesses item='business' }}
                                        <option value="{{ $business.business_id }}"{{ if $business.business_id == $category.business_id }} selected="selected"{{ /if }}>{{ $business.name }}</option>
{{ /foreach }}
                                    </select>
                                    </b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="parent_id">所属分类:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <span id="category-zone"></span>
                                    </b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="name">分类名称:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="name" name="name" value="{{$category.name}}" /></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <input class="ibtn ibtn-ok" type="submit" value="保存" />
                                    <input id="cate_id" name="cate_id" type="hidden" value="{{$category.cate_id}}" />
                                    <input id="lang" name="lang" type="hidden" value="{{$category.lang}}" />
                                    <input id="col_key" name="col_key" type="hidden" value="{{$category.col_key}}" />
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
         * 添加分类执行 
         */
        $('#business_id').change(function(){

            $.get('{{ url controller='Merchant' action='SelectBusiness' }}&addtype=category&business=' + $('#business_id option:selected').attr('value'), function(data){
                if (data) {
                    $('#category-zone').html(data);
                }
            });
        });
        /**
         * 编辑执行 
         */
        $.get('{{ url controller='Merchant' action='SelectBusiness' }}&addtype=category&business={{ $category.business_id }}&parent_id={{ $category.parent_id }}', function(data){
            if (data) {
                $('#category-zone').html(data);
            }
        });
    });
</script>

</body>

</html>

