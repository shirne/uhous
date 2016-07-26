{{ include file='layouts/head.tpl' }}

<div class="inner-content">
{{ if $smarty.get.colkey eq 'payment' }}
{{ assign var='col_name' value='支付方式' }}
{{ else if $smarty.get.colkey eq 'delivery' }}
{{ assign var='col_name' value='配送方式' }}
{{ /if}}

{{ if $setup.set_id }}

    {{ assign var='label' value=编辑$col_name }}

{{ else }}

    {{ assign var='label' value=添加$col_name }}

{{ /if }}

{{ webcontrol type='Position' name='position' column='栏目管理' position=$label footprint='yes' }}

{{ include file='modules/setup/cmd.tpl' }}

    <div class="layout clearfix">

        <div class="box">
            <h3>{{ $label }}</h3>
            <div class="form">
            <form id="editform" name="editform" action="{{ url controller='Setup' action='Save' }}" method="post"  enctype="multipart/form-data">
                <table>
                    <tr>
                        <td>
                            <p>
                                <label for="name">{{$col_name}}名称:</label>
                                <b class="fluid-input"><b class="fluid-input-inner">
                                <input class="itext" type="text" id="name" name="name" value="{{ $setup.name }}" />
                                </b></b>
                            </p>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <p>
                                <label for="params[link]">链接:</label>
                                <b class="fluid-input"><b class="fluid-input-inner">
                                <input class="itext" type="text" id="cost" name="params[link]" value="{{ $setup.params.link }}" />
                                </b></b>
                                <small>请不要加"http://"</small>
                            </p>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <p>
                                <label for="cost">费用:</label>
                                <b class="fluid-input"><b class="fluid-input-inner">
                                <input class="itext" type="text" id="cost" name="cost" value="{{ $setup.cost }}" />
                                </b></b>
                            </p>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <p>
                                <label for="memo">描述:</label>
                                <b class="fluid-input"><b class="fluid-input-inner">
                                {{ webcontrol type='editor' name='memo' value=$setup.memo class='itext' }}
                                </b></b>
                            </p>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <p>
                                <input class="ibtn ibtn-ok" type="submit" value="保存" />
                                <input id="set_id" name="set_id" type="hidden" value=" {{ $setup.set_id }} " />
                                <input id="col_key" name="col_key" type="hidden" value="{{ $setup.col_key}}" />
                                <input id="lang" name="lang" type="hidden" value="{{ $setup.lang }}" />
                            </p>
                        </td>
                    </tr>

                </table>
            </form>
            </div>
        </div>

    </div>

</div>

</body>

</html>
