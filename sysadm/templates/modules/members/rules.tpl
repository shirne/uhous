{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='栏目管理' position='设置规则' footprint='yes' }}

{{ assign var='cmdType' value='plan' }}

{{ include file='modules/members/cmd.tpl' }}

<div class="layout clearfix">

        <div class="box">
            <h3>[{{$plan.label}}] 规则设置</h3>
            <div class="form">

                <form id="editform" name="editform" action="{{ url controller='Member' action='SaveRule' }}" method="post">
                    <table>
                        <tr>
                            <td style="width: 32%;">
                                <p>
                                    <label for="name">显示金额:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="name" name="name" value="{{$rule.name}}" /></b></b>
                                    <small>示例: 3万。</small>
                                </p>
                            </td>
                            <td style="width: 2%;"></td>
                            <td style="width: 32%;">
                                <p>
                                    <label for="money">数值金额:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="money" name="money" value="{{$rule.money}}" /></b></b>
                                    <small>示例: 30000。</small>
                                </p>
                            </td>
                            <td style="width: 2%;"></td>
                            <td style="width: 32%;">
                                <p>
                                    <label for="discount">折扣:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="discount" name="discount" value="{{$rule.discount}}" /></b></b>
                                    <small>示例: 0.9。</small>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <p>
                                    <input class="ibtn ibtn-ok" type="submit" value="保存" />
                                    <input id="plan_id" name="plan_id" type="hidden" value="{{$plan.plan_id}}" />
                                    <input id="rule_id" name="rule_id" type="hidden" value="{{$rule.rule_id}}" />
                                    <input id="col_key" name="col_key" type="hidden" value="{{$plan.col_key}}" />
                                    <input id="lang" name="lang" type="hidden" value="{{$plan.lang}}" />
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <p>
                                    <fieldset class="fold">
                                        <legend>折上折规则</legend>
                                        <div>
                                            <ul class="inline-list clearfix">
{{ foreach from=$plan.rules item=rule }}
                                                <li><span style="background: #FFE19D; padding: 1px 4px;">{{$rule.name}}</span> <a href="{{ url controller='Member' action='ModifyRule' id=$plan.plan_id rule_id=$rule.rule_id }}">修改</a> | <a href="{{ url controller='Member' action='RemoveRule' id=$plan.plan_id rule_id=$rule.rule_id }}">删除</a></li>
{{ /foreach }}
                                            </ul>
                                        </div>
                                    </fieldset>
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

