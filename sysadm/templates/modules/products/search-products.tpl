{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='栏目管理' position='搜索商品' footprint='yes' }}

{{ assign var='cmdType' value='products' }}

{{ include file='modules/products/cmd.tpl' }}

<div class="layout clearfix">

        <div class="box">
            <h3>搜索商品</h3>
            <div class="form">

                <form id="editform" name="editform" action="{{ url controller='Products' search='yes' }}" method="post">
                    <table>
                        <tr>
                            <td style="width: 33.33%;">
                                <p>
                                    <label for="cate_id">所属分类:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <select id="cate_id" name="cate_id">
                                        <option value="0">搜索全部分类</option>
{{ foreach from=$categories item=cate }}
{{ if $cate.children }}
    <optgroup label="{{$cate.name}}">
    {{ foreach from=$cate.children item=child }}
        <option value="{{$child.cate_id}}">{{$child.name}}</option>
    {{ /foreach }}
    </optgroup>
{{ else }}
    <option value="{{$cate.cate_id}}">{{$cate.name}}</option>
{{ /if }}
{{ /foreach }}
                                    </select>
                                    </b></b>
                                </p>
                            </td>
                            <td style="width: 33.33%;">
                                <p>
                                    <label for="brand_id">所属品牌:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <select id="brand_id" name="brand_id">
                                        <option value="0">搜索全部品牌</option>
{{ foreach from=$brands item=brand }}
    <option value="{{$brand.brand_id}}">{{$brand.name}}</option>
{{ /foreach }}
                                    </select>
                                    </b></b>
                                </p>
                            </td>
                            <td style="width: 33.33%;">
                                <p>
                                    <label for="displayorder">商品属性:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <select id="displayorder" name="displayorder">
                                        <option value="0">搜索所有属性</option>
                                        <option value="1">普通商品</option>
                                        <option value="2">最新商品</option>
                                        <option value="3">热门商品</option>
                                        <option value="4">推荐商品</option>
                                    </select>
                                    </b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <p>
                                    <label for="name">商品名称:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="name" name="name" value="" /></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <p>
                                    <label for="procode">商品编号:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="procode" name="procode" value="" /></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <p>
                                    <label for="specification">商品规格:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="specification" name="specification" value="" /></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <p>
                                    <label for="pro_id">商品ID:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="pro_id" name="pro_id" value="" /></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <p>
                                    <input class="ibtn ibtn-ok" type="submit" value="开始搜索" />
                                    <input id="col_key" name="col_key" type="hidden" value="{{$colkey}}" />
                                    <input id="lang" name="lang" type="hidden" value="{{$lang}}" />
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

