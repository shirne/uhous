{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='栏目管理' position='留言列表' footprint='yes' }}

{{ include file='modules/guestbook/cmd.tpl' }}

    <div class="layout clearfix">

        <div class="box">
            <h3>留言列表</h3>
            <form id="listform" name="listform" action="{{ url controller='Guestbook' action='Remove' }}" method="post">
                <table class="table-data">
                    <thead>
                        <tr>
                            <th width="5%"><input id="checkall" name="checkall" type="checkbox" /></th>
                            <th width="30%">留言标题</th>
                            <th width="15%">联系人</th>
                            <th width="10%">联系电话</th>
                            <th width="7%">审核</th>
                            <th width="15%">提交日期</th>
                            <th>管理</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th><input class="ibtn" type="button" value="删除所选" onclick="remove_confirm('#listform', '')" /></th>
                            <th colspan="8">
{{ webcontrol type='Pagenav' name='pager' pager=$pager prevLabel='上一页' nextLabel='下一页' controller=$controller action=$action colkey=$colkey lang=$lang search=$search msg_id=$msg_id username=$username phone=$phone title=$title}}
                            </th>
                        </tr>
                    </tfoot>
                    <tbody>
{{ foreach from=$messages item=message }}
                        <tr>
                            <td class="tc"><input id="check[]" name="check[]" type="checkbox" value="{{ $message.msg_id }}" /></td>
                            <td><a href="{{ url controller='Guestbook' action='Modify' id=$message.msg_id }}">{{ $message.title }}</a></td>
                            <td class="tc">{{ $message.member.username }}</td>
                            <td class="tc">{{ $message.member.phone }}</td>
                            <td class="tc">
                                {{ if $message.dismiss eq 1 }}
                                <img src="/sysadm/img/hook.jpg" />
                                {{ /if }}
                            </td>
                            <td class="tc">{{ $message.created|date_format:'%Y-%m-%d' }}</td>
                            <td class="tc">
                                <a href="{{ url controller='Guestbook' action='Modify' id=$message.msg_id }}">查看/回复</a> | 
                                <a href="{{ url controller='Guestbook' action='Remove' id=$message.msg_id }}" onclick="remove_confirm('#listform', this); return(false);">删除</a>
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
