{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='栏目管理' position='商品列表' footprint='yes' }}

{{ assign var='cmdType' value='comments' }}

{{ include file='modules/products/cmd.tpl' }}

    <div class="layout clearfix">

        <div class="box">
            <h3>商品评论</h3>
            <form id="listform" name="listform" action="{{ url controller='Products' action='RemoveComments' }}" method="post">
                <table class="table-data">
                    <thead>
                        <tr>
                            <th width="5%"><input id="checkall" name="checkall" type="checkbox" /></th>
                            <th width="40%">评论内容</th>
                            <th width="15%">评论人</th>
                            <th width="15%">发布日期</th>
                            <th>管理</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th><input class="ibtn" type="button" value="删除所选" onclick="remove_confirm('#listform', '')" /></th>
                            <th colspan="7">
{{ webcontrol type='Pagenav' name='pager' pager=$pager prevLabel='上一页' nextLabel='下一页' controller=$controller action=$action colkey=$colkey lang=$lang search=$search cate_id=$cate_id brand_id=$brand_id displayorder=$displayorder pro_id=$pro_id name=$name procode=$procode specification=$specification }}
                            </th>
                        </tr>
                    </tfoot>
                    <tbody>
{{ foreach from=$rows item=row }}
                        <tr>
                            <td class="tc"><input id="check[]" name="check[]" type="checkbox" value="{{$row.com_id}}" /></td>
                            <td class="tc">{{$row.memo}}</td>
                            <td class="tc"><a href="{{url controller='Member' action='Modify' id=$row.member.member_id colkey='member'}}">{{$row.member.username}}</a></td>
                            <td class="tc">{{$row.created|date_format:'%Y/%m/%d  %H:%M:%S'}}</td>
                            <td class="tc">
                                <a href="{{ url controller='Products' action='ReplyComments' id=$row.com_id }}">回复</a> |
                                <a href="{{ url controller='Products' action='RemoveComments' id=$row.com_id }}" onclick="remove_confirm('#listform', this); return(false);">删除</a>
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

