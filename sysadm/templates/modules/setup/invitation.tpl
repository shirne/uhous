{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='系统管理' position='邀请范文设置' printfoot=false }}

    <div class="layout clearfix mt">

        <div class="box">
            <h3>邀请范文设置</h3>
            <div class="form">

                <form id="editform" name="editform" action="{{ url controller='Settings' action='Save' }}" method="post">
                    <table>
                        <tr>
                            <td>
                                <p>
                                    <label for="invitation1">范文1:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='Editor' name='invitation1' value=$invitation1 height='150' }}</b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="invitation2">范文2:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='Editor' name='invitation2' value=$invitation2 height='150' }}</b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="invitation3">范文3:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='Editor' name='invitation3' value=$invitation3 height='150' }}</b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="select">选择范文模板:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                        <select id="selectDemo">
                                            <option value="0">--选择--</option>
                                            <option value="1">范文1</option>
                                            <option value="2">范文2</option>
                                            <option value="3">范文3</option>
                                        </select>
                                    </b></b>
                                    <small>选中的范文模板，将在前台邀请好友的编辑框中显示.</small>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <input name="invitation" type="hidden" value="" />
                                    <input class="ibtn ibtn-ok" type="submit" value="保存设置" />
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
jQuery(function($) {
    $("#selectDemo").change(function() {
        var editor=FCKeditorAPI.GetInstance("invitation" + $("#selectDemo").val());
        $("input[name='invitation']").val(editor.GetXHTML());
    });
});
</script>

</body>

</html>

