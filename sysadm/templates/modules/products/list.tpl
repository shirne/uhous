{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='栏目管理' position='商品列表' footprint='yes' }}

{{ assign var='cmdType' value='products' }}

{{ include file='modules/products/cmd.tpl' }}

    <div class="layout clearfix">

        <div class="box">
            <h3>商品列表</h3>
            <form id="listform" name="listform" action="{{ url controller='Products' action='Remove' }}" method="post">
                <table class="table-data">
                    <thead>
                        <tr>
                            <th width="5%"><input id="checkall" name="checkall" type="checkbox" /></th>
                            <th width="14%">商品名称</th>
                            <th width="10%">商品图片</th>
                            <th width="10%">所属分类</th>
                            <th width="10%">所属品牌</th>
                            <th width="5%">显示</th>
                            <th width="8%">运费</th>
                            <th width="8%">商品单价</th>
                            <th width="5%">副图</th>
                            <th>管理</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>
                                <input class="ibtn" type="button" value="删除所选" onclick="remove_confirm('#listform', '')" />
                            </th>
                            <th colspan="9">
{{ webcontrol type='Pagenav' name='pager' pager=$pager prevLabel='上一页' nextLabel='下一页' controller=$controller action=$action colkey=$colkey lang=$lang search=$search cate_id=$cate_id brand_id=$brand_id displayorder=$displayorder pro_id=$pro_id name=$name procode=$procode specification=$specification }}
                            </th>
                        </tr>
                    </tfoot>
                    <tbody>
{{ foreach from=$products item=product }}
                        <tr>
                            <td class="tc"><input id="check[]" name="check[]" type="checkbox" value="{{$product.pro_id}}" /></td>
                            <td>{{ $displayType[$product.displayorder] }}<a href="{{ url controller='Products' action='Modify' id=$product.pro_id }}">{{$product.name}}</a></td>
                            <td class="tc"><img src="/{{ get_app_inf key='uploadDir' }}thumb_{{$product.pic}}" height="60" /></td>
                            <td class="tc"><a href="{{ url controller='Products' cate_id=$product.cate_id }}">{{$product.category.name}}</a></td>
                            <td class="tc"><a href="{{ url controller='Products' brand_id=$product.brand_id }}">{{$product.brand.name}}</a></td>
                            <td class="tc">{{ if $product.display eq 1 }}<img src="/sysadm/img/hook.jpg" alt="ok" />{{else}}<img src="/sysadm/img/fail.jpg" alt="fail" />{{ /if }}</td>
                            <td class="tc">{{ if $product.delivery_cost eq 0 }}包邮{{else}}{{$product.delivery_cost}}{{ /if }}</td>
                            <td class="tc">{{$product.price}} &yen;</td>
                            <td class="tc">{{$product.photos|@count}}</td>
                            <td class="tc">
{{ if $product.display eq 0 }}
                                <a href="{{ url controller='Products' action='display' display=1 id=$product.pro_id colkey='attribute' }}">显示</a> | 
{{ else }}
                                <a href="{{ url controller='Products' action='display' display=0 id=$product.pro_id colkey='attribute' }}">隐藏</a> | 
{{ /if }}
                                <a href="{{ url controller='Products' action='Photos' id=$product.pro_id }}">上传副图</a> | 
                                <!--a href="{{ url controller='Products' action='Attribute' id=$product.pro_id colkey='attribute' }}">属性</a> | -->
                                <a href="{{ url controller='Products' action='Comments' id=$product.pro_id }}">评论</a> | 
                                <a href="{{ url controller='Products' action='Modify' id=$product.pro_id }}">编辑</a> | 
                                <a href="{{ url controller='Products' action='Copy' id=$product.pro_id }}">复制</a> | 
                                <a href="{{ url controller='Products' action='Remove' id=$product.pro_id }}" onclick="remove_confirm('#listform', this); return(false);">删除</a>
                            </td>
                        </tr>
{{ /foreach }}
                    </tbody>
                </table>
            </form>
        </div>

        <div class="clear"><!-- Clear Float --></div>

    </div>

</div>

</body>

</html>

