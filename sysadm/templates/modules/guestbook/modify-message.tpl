{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='栏目管理' position='查看留言' footprint='yes' }}

{{ include file='modules/guestbook/cmd.tpl' }}

<div class="layout clearfix">

        <div class="box">
            <h3>查看留言</h3>
            <div class="form">

                <form id="editform" name="editform" action="{{ url controller='Guestbook' action='Disabled' msg_id=$message.msg_id }}" method="post"  enctype="multipart/form-data">
                    <table>
                        <tr>
                            <td width="20%" colspan="7">
                                <p>
                                    <label for="name">留言标题:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <div class="itext" style="font-weight: normal;">{{ $message.title }}</div>
                                    </b></b>
                                </p>
                            </td>
                            <td width="2%"></td>
                        </tr>
                        <tr>
                            <td width="20%" colspan="7">
                                <p>
                                    <label for="content">留言内容:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <div class="itext" style="font-weight: normal; height: 80px;">{{ $message.content }}</div>
                                    </b></b>
                                </p>
                            </td>
                            <td width="2%"></td>
                        </tr>
                        <tr>
                            <td width="20%">
                                <p>
                                    <label for="member">留言人:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <div class="itext" style="font-weight: normal;">{{ $message.member.username }}</div>
                                    </b></b>
                                </p>
                            </td>
                            <td width="2%"></td>
                            <td width="20%">
                                <p>
                                    <label for="phone">留言人电话:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <div class="itext" style="font-weight: normal;">{{ $message.member.phone }}</div>
                                    </b></b>
                                </p>
                            </td>
                            <td width="2%"></td>
                            <td width="20%">
                                <p>
                                    <label for="QQ">留言人QQ:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <div class="itext" style="font-weight: normal;">{{ $message.member.qq }}</div>
                                    </b></b>
                                </p>
                            </td>
                            <td width="2%"></td>
                            <td width="20%">
                                <p>
                                    <label for="state">状态:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <div class="itext" style="font-weight: normal;">
                                        {{ if $message.dismiss eq 0 }} 驳回
                                        {{ else if $message.dismiss eq 1 }} 通过
                                        {{ /if }}
                                    </div>
                                    </b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="hidden" name="msg_id" id="msg_id" value="{{ $message.msg_id }}" />
                                <input type="hidden" name="lang" id="lang" value="{{ $message.lang }}" />
                                <input type="hidden" name="col_key" id="col_key" value="{{ $message.col_key }}" />
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        <br />
        <div class="box">
            <h3>回复留言</h3>
            <div class="form">

                <form id="replyform" name="replyform" action="{{ url controller='Guestbook' action='SaveReply' msg_id=$message.msg_id }}" method="post"  enctype="multipart/form-data">
                    <table>
                        <tr>
                            <td width="85%">
                                <p>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <textarea name="reply" class="itext">{{ $message.reply }}</textarea>
                                    </b></b>
                                </p>
                            </td>
                            <td width="3%"></td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <input type="submit" name="sub_reply" id="submit" class="ibtn ibtn-ok" value="审核并回复" />
                                    <input type="submit" name="pass" id="pass" value="审核" class="ibtn ibtn-ok" />
                                    <input type="submit" name="dismiss" id="dismiss" value="驳回" class="ibtn ibtn-ok" />
                                    <input type="hidden" name="msg_id" id="msg_id" value="{{ $message.msg_id }}" />
                                    <input type="hidden" name="lang" id="lang" value="{{ $message.lang }}" />
                                    <input type="hidden" name="col_key" id="col_key" value="{{ $message.col_key }}" />
                                </p>
                                <small>审核通过的留言将会在前台显示</small>
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
