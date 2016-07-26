{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='栏目管理' position='方案列表' footprint='yes' }}

{{ assign var='cmdType' value='plan' }}

{{ include file='modules/members/cmd.tpl' }}

    <div class="layout clearfix">

        <div class="box">
            <h3>方案列表</h3>
            <form id="listform" name="listform" action="{{ url controller='Member' action='RemovePlans' }}" method="post">
                <table class="table-data">
                    <thead>
                        <tr>
                            <th width="5%"><input id="checkall" name="checkall" type="checkbox" /></th>
                            <th width="20%">方案名称</th>
                            <th width="15%">正常折扣</th>
                            <th width="15%">月进货额</th>
                            <th width="15%">年进货额</th>
                            <th width="10%">会员数量</th>
                            <th>管理</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th colspan="7"><input class="ibtn" type="button" value="删除所选" onclick="remove_confirm('#listform', '')" /></th>
                        </tr>
                    </tfoot>
                    <tbody>
{{ foreach from=$plans item=plan }}
                        <tr>
                            <td class="tc"><input id="check[]" name="check[]" type="checkbox" value="{{$plan.plan_id}}" /></td>
                            <td><a href="{{ url controller='Member' action='ModifyPlan' id=$plan.plan_id}}">{{$plan.label}}</a></td>
                            <td class="tc">{{$plan.discount}}</td>
                            <td class="tc">{{$plan.month_money}}</td>
                            <td class="tc">{{$plan.year_money}}</td>
                            <td class="tc">{{$plan.counts}}</td>
                            <td class="tc"><a href="{{ url controller='Member' action='ModifyRule' id=$plan.plan_id }}">设置规则</a> | <a href="{{ url controller='Member' action='ModifyPlan' id=$plan.plan_id}}">编辑</a> | <a href="{{ url controller='Member' action='RemovePlans' id=$plan.plan_id}}" onclick="remove_confirm('#listform', this); return(false);">删除</a></td>
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

