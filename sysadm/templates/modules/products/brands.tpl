{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='栏目管理' position='品牌列表' footprint='yes' }}

{{ assign var='cmdType' value='brands' }}

{{ include file='modules/products/cmd.tpl' }}

    <div class="layout clearfix">

        <div class="box">
            <h3>品牌列表</h3>
            <form id="listform" name="listform" action="{{ url controller='Products' action='RemoveBrands' }}" method="post">
                <table class="table-data">
                    <thead>
                        <tr>
                            <th width="5%"><input id="checkall" name="checkall" type="checkbox" /></th>
                            <th width="10%">品牌名称</th>
                            <th width="30%">品牌LOGO</th>
                            <th width="30%">品牌图片</th>
                            <th width="10%">创建日期</th>
                            <th>管理</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th colspan="5"><input class="ibtn" type="button" value="删除所选" onclick="remove_confirm('#listform', '')" /></th>
                        </tr>
                    </tfoot>
                    <tbody>
{{ foreach from=$brands item=brand }}
                        <tr>
                            <td class="tc"><input id="check[]" name="check[]" type="checkbox" value="{{$brand.brand_id}}" /></td>
                            <td class="tc"><a href="{{ url controller='Products' action='ModifyBrand' id=$brand.brand_id }}">{{$brand.name}}</a></td>
                            <td class="tc">{{ if $brand.logo }}<img src="/{{ get_app_inf key='uploadDir' }}{{$brand.logo}}" height="80" />{{ /if }}</td>
                            <td class="tc">{{ if $brand.pic }}<img src="/{{ get_app_inf key='uploadDir' }}{{$brand.pic}}" height="80" />{{ /if }}</td>
                            <td class="tc">{{$brand.created|date_format:'%Y/%m/%d %H:%M:%S'}}</td>
                            <td class="tc"><a href="{{ url controller='Products' action='ModifyBrand' id=$brand.brand_id }}">编辑</a> | <a href="{{ url controller='Products' action='RemoveBrands' id=$brand.brand_id }}" onclick="remove_confirm('#listform', this); return(false);">删除</a></td>
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

