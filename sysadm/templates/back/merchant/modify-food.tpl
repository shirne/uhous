{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ if $food.food_id }}

    {{ assign var='label' value='编辑服务项' }}

{{ else }}

    {{ assign var='label' value='添加服务项' }}

{{ /if }}

{{ webcontrol type='Position' name='position' column='栏目管理' position=$label footprint='yes' }}

{{ assign var='cmdType' value='foods' }}

{{ include file='modules/merchant/cmd.tpl' }}

<div class="layout clearfix">

        <div class="box">
            <h3>{{$label}}</h3>
            <div class="form">

                <form id="editform" name="editform" action="{{ url controller='Merchant' action='SaveFood' }}" method="post"  enctype="multipart/form-data">
                    <table>
                        <tr>
                            <td style="width: 20%;">
                                <p>
                                    <label for="cate_id">所属商家:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    {{ $merchantInfo.name }}
                                    </b></b>
                                </p>
                            </td>  
                            <td></td>
                            <td style="width: 20%;">
                                <p>
                                    <label for="cate_id">所属分类:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <span id="categories-zone">
                                        <select name="cate_id">
                                            <option value="0">请选择分类</option>
                                            {{foreach from=$categories item='row'}}
                                            <option {{if ($food.parent_id eq $row.cate_id) or ($food.cate_id eq $row.cate_id)}}selected="selected"{{/if}} value="{{$row.cate_id}}" rel="{{$row.business_id}}">{{$row.name}}</option>
                                            {{/foreach}}
                                        </select>
                                    </span>
                                    <span id="subcategory-zone"></span>
                                    </b></b>
                                </p>
                            </td>    
                            <td></td>
                        </tr>
                        <tr>
                            <td width="20%">
                                <p>
                                    <label for="name">服务项名称:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='textbox' name='name' value=$food.name class='itext' }}</b></b>
                                </p>
                            </td>
                            <td width="2%"></td>
                            <td width="20%">
                                <p>
                                    <label for="price">服务项价格:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='textbox' name='price' value=$food.price class='itext' }}</b></b>
                                </p>
                            </td>
                            <td width="2%"></td>
                            <td width="20%">
                                <p>
                                    <label for="comment_level">评价等级:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='textbox' name='comment_level' value=$food.comment_level class='itext' }}
                                    </b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <p>
                                    <label for="memo">描述:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    {{ webcontrol type='Editor' name='memo' value=$food.memo style='Basic' height='120' }}
                                    </b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="logo">服务项图片:</label>
{{ if $food.pic }}
                                    <div>
                                        <img src="/{{ get_app_inf key='uploadDir' }}{{$food.pic}}" height="32" />
                                        <a href="/{{ get_app_inf key='uploadDir' }}{{$food.pic}}" target="_blank">查看原图</a> | <a href="{{ url controller='Merchant' action='RemoveFoodPic' id=$food.food_id }}">删除图片</a>
                                    </div>
                                    <small>如需要重新上传图片，须先删除图片。</small>
{{ else }}
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="file" id="pic" name="pic" /></b></b>
                                    <small>图片尺寸：360px X 360px (像素)。</small>
{{ /if }}
                                </p>
                            </td>
                            <td></td>
                        </tr>

                        <tr>
                            <td colspan="5">
                                <p>
                                    <input class="ibtn ibtn-ok" type="submit" value="保存" />
                                    <input id="food_id" name="food_id" type="hidden" value="{{$food.food_id}}" />
                                    <input id="merc_id" name="merc_id" type="hidden" value="{{$merchantInfo.merc_id}}" />
                                    <input id="col_key" name="col_key" type="hidden" value="{{$food.col_key}}" />
                                    <input id="lang" name="lang" type="hidden" value="{{$food.lang}}" />
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
        $('#categories-zone').change(function(){
            $.get('{{ url controller='Merchant' action='SelectCategory' colkey='food' }}&addtype=merchant&business=' + $('#categories-zone option:selected').attr('rel') + '&cate_id=' + $('#categories-zone option:selected').attr('value'), function(data){
                if (data) {
                    $('#subcategory-zone').html(data);
                }
            });
        });
    });
</script>

{{ if $food.food_id }}
<script type="text/javascript">
    $(document).ready(function(){
        /**
         * 选择分类--编辑商家
         */
        $.get('{{ url controller='Merchant' action='SelectCategory' colkey='food' }}&addtype=merchant&business=' + {{ $merchantInfo.category.business_id }} +  '&cate_id={{ $food.parent_id }}&sub_id=' + {{ $food.cate_id }}, function(data){
            if (data) {
                $('#subcategory-zone').html(data);
            }
        });
    });
</script>
{{ /if }}

</body>

</html>
