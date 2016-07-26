{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ if $plan.plan_id }}

    {{ assign var='label' value='编辑方案' }}

{{ else }}

    {{ assign var='label' value='添加方案' }}

{{ /if }}

{{ webcontrol type='Position' name='position' column='栏目管理' position=$label footprint='yes' }}

{{ assign var='cmdType' value='plan' }}

{{ include file='modules/members/cmd.tpl' }}

<div class="layout clearfix">

        <div class="box">
            <h3>{{$label}}</h3>
            <div class="form">

                <form id="editform" name="editform" action="{{ url controller='Member' action='SavePlan' }}" method="post">
                    <table>
                        <tr>
                            <td width="49%">
                                <p>
                                    <label for="label">方案名称:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='textbox' name='label' class='itext' value=$plan.label }}</b></b>
                                    <small>用于识别会员方案。</small>
                                </p>
                            </td>
                            <td width="2%"></td>
                            <td width="49%">
                                <p>
                                    <label for="name">方案代号:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='textbox' name='name' class='itext' value=$plan.name }}</b></b>
                                    <small>用于对接本地流。</small>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="discount">正常折扣:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='textbox' name='discount' class='itext' value=$plan.discount }}</b></b>
                                </p>
                            </td>
                            <td></td>
                            <td>
                                <p>
                                    <label for="base_money">保证金额:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='textbox' name='base_money' class='itext' value=$plan.base_money }}</b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="month_money">月购金额:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='textbox' name='month_money' class='itext' value=$plan.month_money }}</b></b>
                                </p>
                            </td>
                            <td></td>
                            <td>
                                <p>
                                    <label for="year_money">年购金额:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='textbox' name='year_money' class='itext' value=$plan.year_money }}</b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <fieldset class="fold">
                                    <legend>参与折扣的品牌:</legend>
                                    <div>
                                        {{ webcontrol type='checkboxgroup' name='brands' items=$brands selected=$plan.brands }}
                                    </div>
                                </fieldset>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <p>
                                    <input class="ibtn ibtn-ok" type="submit" value="保存方案" />
{{ if $plan.plan_id }}<input class="ibtn" type="button" value="设置规则" onclick="window.location.href='{{ url controller='Member' action='ModifyRule' id=$plan.plan_id }}'" />{{ /if }}
                                    <input id="plan_id" name="plan_id" type="hidden" value="{{$plan.plan_id}}" />
                                    <input id="col_key" name="col_key" type="hidden" value="{{$plan.col_key}}" />
                                    <input id="lang" name="lang" type="hidden" value="{{$plan.lang}}" />
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

