{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='栏目管理' position='商品列表' footprint='yes' }}

{{ assign var='cmdType' value='comments' }}

{{ include file='modules/products/cmd.tpl' }}

<div class="layout clearfix">

        <div class="box">
            <h3>{{$comment.member.username}} 来自 {{$comment.member.email}} {{$comment.created|date_format:'%Y-%m-%d %H:%M:%S'}}</h3>
            <div class="form">

                <form id="editform" name="editform" action="{{ url controller='Products' action='SaveReply' }}" method="post" enctype="multipart/form-data">
                    <table>
                        <tr>
                            <td>
                                <p>
                                    <label for="reply">
                                        {{$comment.memo}}
                                    </label>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="reply">回复：</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='editor' name='reply' value=$comment.reply class='itext' id='reply'  height="150" }}</b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <input class="ibtn ibtn-ok" type="submit" value="保存" />
                                    <input id="com_id" name="com_id" type="hidden" value="{{$comment.com_id}}" />
                                    <input id="col_key" name="col_key" type="hidden" value="{{$comment.col_key}}" />
                                    <input id="lang" name="lang" type="hidden" value="{{$comment.lang}}" />
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

