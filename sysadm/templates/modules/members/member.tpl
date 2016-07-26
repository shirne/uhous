{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='栏目管理' position='会员列表' footprint='yes' }}

{{ assign var='cmdType' value='member' }}

{{ include file='modules/members/cmd.tpl' }}

    <div class="layout clearfix">

        <div class="box">
            <h3>会员列表</h3>
            <form id="listform" name="listform" action="{{ url controller='Member' action='Remove' }}" method="post">
                <table class="table-data">
                    <thead>
                        <tr>
                            <th width="5%"><input id="checkall" name="checkall" type="checkbox" /></th>
                            <th width="6%">会员等级</th>
                            <th width="20%">会员名称</th>
                            <th width="12%">邮箱地址</th>
                            <th width="10%">积分</th>
                            <th width="12%">创建日期</th>
                            <th>管理</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th><input class="ibtn" type="button" value="删除所选" onclick="remove_confirm('#listform', '')" /></th>
                            <th colspan="6">
{{ webcontrol type='Pagenav' name='pager' pager=$pager prevLabel='上一页' nextLabel='下一页' controller=$controller action=$action colkey=$colkey lang=$lang search=$search member_id=$member_id username=$username }}
                            </th>
                        </tr>
                    </tfoot>
                    <tbody>
{{ foreach from=$members item=member }}
                        <tr>
                            <td class="tc"><input id="check[]" name="check[]" type="checkbox" value="{{$member.member_id}}" /></td>
                            <td class="tc">{{$member.level.levels}}</td>
                            <td class="tc"><a href="{{ url controller='Member' action='Modify' id=$member.member_id }}">{{$member.username}}</a></td>
                            <td class="tc">{{$member.email}}</td>
                            <td class="tc">{{$member.points}}</td>
                            <td class="tc">{{$member.created|date_format:'%Y/%m/%d %H:%M:%S'}}</td>
                            <td class="tc">
                                <a href="{{ url controller='Member' action='Modify' id=$member.member_id }}">编辑</a> | 
                                <a href="{{ url controller='Member' action='Address' id=$member.member_id }}">收货地址</a> | 
                                <a href="{{ url controller='Order' member_id=$member.member_id colkey='order' search='yes'}}">订单查询</a> | 
                                <a href="{{ url controller='Member' action='Remove' id=$member.member_id }}" onclick="remove_confirm('#listform', this); return(false);">删除</a>
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

