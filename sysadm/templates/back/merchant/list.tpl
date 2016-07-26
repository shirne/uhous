{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='栏目管理' position='商家列表' footprint='yes' }}

{{ assign var='cmdType' value='merchant' }}

{{ include file='modules/merchant/cmd.tpl' }}

    <div class="layout clearfix">

        <div class="box">
            <h3>商家列表</h3>
            <form id="listform" name="listform" action="{{ url controller='Merchant' action="Remove" }}" method="post">
                <table class="table-data">
                    <thead>
                        <tr>
                            <th width="5%"><input id="checkall" name="checkall" type="checkbox" /></th>
                            <th width="15%">商家名称</th>
                            <th width="15%">商家图片</th>
                            <th width="25%">商家地址</th>
                            <th width="5%">开通点餐</th>
                            <th width="10%">创建日期</th>
                            <th>管理</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th><input class="ibtn" type="button" value="删除所选" onclick="remove_confirm('#listform', '')" /></th>
                            <th><input class="ibtn" type="button" value="开通点餐" onclick="ctl_submit('#listform', '{{ url controller='Merchant' action='Recommend' rmd=1 }}')" />
                                <input class="ibtn" type="button" value="取消点餐" onclick="ctl_submit('#listform', '{{ url controller='Merchant' action='Recommend' rmd=0 }}')" /></th>
                            <th colspan="8">
{{ webcontrol type='Pagenav' name='pager' pager=$pager prevLabel='上一页' nextLabel='下一页' controller=$controller action=$action colkey=$colkey lang=$lang search=$search cate_id=$cate_id merc_id=$merc_id business_id=$business_id area=$area_id street_id=street_id subarea=$subarea_id }}
                            </th>
                        </tr>
                    </tfoot>
                    <tbody>
{{ foreach from=$merchants item=merchant }}
                        <tr>
                            <td class="tc"><input id="check[]" name="check[]" type="checkbox" value="{{ $merchant.merc_id }}" /></td>
                            <td><a href="{{ url controller='Merchant' action='Modify' id=$merchant.merc_id }}">{{ $merchant.name }}</a></td>
                            <td class="tc"><img src="/{{ get_app_inf key='uploadDir' }}{{ $merchant.logo }}" height="60" /></td>
                            <td class="tc">{{ $merchant.address }}</td>
                            <td class="tc">
                                {{ if $merchant.recommend eq 1 }}
                                    <img src="/sysadm/img/hook.jpg" />
                                {{ /if }}
                            </td>
                            <td class="tc">{{ $merchant.created|date_format:'%Y-%m-%d' }}</td>
                            <td class="tc">
                                <a href="{{ url controller='Merchant' action='Foods' merc_id=$merchant.merc_id }}">服务项管理</a> | 
                                <a href="{{ url controller='Merchant' action='Modify' merc_id=$merchant.merc_id }}">编辑</a> | 
                                <a href="{{ url controller='Merchant' action='Remove' merc_id=$merchant.merc_id }}" onclick="remove_confirm('#listform', this); return(false);">删除</a>
                            </td>
                        </tr>
{{ /foreach }}
                    </tbody>
                </table>
            </form>
        </div>

        <span id="test"></span>
        <div class="clear"><!-- Clear Float --></div>

    </div>

</div>

</body>

</html>
