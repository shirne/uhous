{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ assign var='label' value='已保存的有效地址' }}

{{ webcontrol type='Position' name='position' column='栏目管理' position=$label footprint='yes' }}

{{ assign var='cmdType' value='address' }}

{{ include file='modules/members/cmd.tpl' }}

<div class="layout clearfix">

        <div class="box" style="width: 25%; float: left; margin-right: 2%;">

            <h3><a href="{{ url controller='Member' action='Address' id=$members.member_id }}" title="{{$label}}">{{$members.username}}</a> 新增收货地址</h3>
            <div class="form">

                <form id="editform" name="editform" action="{{ url controller='Member' action='SaveAddr' }}" method="post">
                    <table>
                        <tr>
                            <td>
                                <p>
                                    <label for="username">收货人:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='textbox' name='username' value=$addrs.username class='itext' }}</b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="手机号码">手机号码:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='textbox' name='phone' value=$addrs.phone class='itext' }}</b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="电话号码">电话号码:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='textbox' name='tel' value=$addrs.tel class='itext' }}</b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="邮政编码">邮政编码:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='textbox' name='post' value=$addrs.post class='itext' }}</b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="area">选择地区:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    {{ webcontrol type='Area' label='no' prov_id=$addrs.address.province.id city_id=$addrs.address.city.id }}
                                    <select onchange="selectArea(this.value, 'division', null)" id="city" name="city" tabindex="6">
                                        <option value="0">-市区-</option>
                                    </select>
                                    <select onchange="fixForm();" id="division" name="division" tabindex="7">
                                        <option value="0">-县区-</option>
                                    </select>
                                    </b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="收货地址">收货地址:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='memo' name='address' value=$addrs.address.address class='itext' }}</b></b>
                                    <small>* 手机号码，电话号码任选一项，其余均为必填</small>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="标志建筑">标志建筑:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='textbox' name='building' value=$addrs.building class='itext' }}</b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="最佳送货时间">最佳送货时间:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='textbox' name='besttime' value=$addrs.besttime class='itext' }}</b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <p>
                                    <input class="ibtn ibtn-ok" type="submit" value="{{if $smarty.get.add_id}}保存{{else}}添加{{/if}}" />
                                    <input id="member_id" name="member_id" type="hidden" value="{{$members.member_id}}" />
                                    <input id="add_id" name="add_id" type="hidden" value="{{$addrs.add_id}}" />
                                    <input id="col_key" name="col_key" type="hidden" value="{{$members.col_key}}" />
                                    <input id="lang" name="lang" type="hidden" value="{{$members.lang}}" />
                                </p>
                            </td>
                        </tr>
                    </table>
                    <input type="hidden" name="province[id]" value="{{$addrs.address.province.id}}" />
                    <input type="hidden" name="province[name]" value="{{$addrs.address.province.name}}" />
                    <input type="hidden" name="city[id]" value="{{$addrs.address.city.id}}" />
                    <input type="hidden" name="city[name]" value="{{$addrs.address.city.name}}" />
                    <input type="hidden" name="division[id]" value="{{$addrs.address.division.id}}" />
                    <input type="hidden" name="division[name]" value="{{$addrs.address.division.name}}" />
                </form>
            </div>
        </div>

        <div class="box" style="width: 70%; float: left; ">
            <h3>{{$label}}</h3>
            <form id="listform" name="listform" action="{{ url controller='Member' action='RemoveAddr' }}" method="post">
                <table class="table-data">
                    <thead>
                        <tr>
                            <th width="5%"><input id="checkall" name="checkall" type="checkbox" /></th>
                            <th width="8%">收货人</th>
                            <th width="12%">手机号码</th>
                            <th width="30%">收货地址</th>
                            <th width="12%">邮政编码</th>
                            <th width="10%"></th>
                            <th>管理</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th><input class="ibtn" type="button" value="删除所选" onclick="remove_confirm('#listform', '')" /></th>
                            <th colspan="7">
{{ webcontrol type='Pagenav' name='pager' pager=$pager prevLabel='上一页' nextLabel='下一页' controller=$controller action=$action colkey=$colkey lang=$lang search=$search member_id=$member_id username=$username }}
                            </th>
                        </tr>
                    </tfoot>
                    <tbody>
{{ foreach from=$members.addresses item=addr }}
                        <tr>
                            <td class="tc"><input id="check[]" name="check[]" type="checkbox" value="{{$addr.add_id}}" /></td>
                            <td class="tc">{{$addr.username}}</td>
                            <td class="tc">{{$addr.phone}}</td>
                            <td class="tc">{{$addr.address.province.name}}{{$addr.address.city.name}}{{$addr.address.division.name}}{{$addr.address.address}}</td>
                            <td class="tc">{{$addr.post}}</td>
                            <td class="tc">{{if $addr.default == 1}}<span class="red">默认地址</span>{{/if}}</td>
                            <td class="tc">
                                <a href="{{ url controller='Member' action='ModifyAddr' id=$addr.member_id add_id=$addr.add_id }}">编辑</a> | 
                                {{if $addr.default == 0}}
                                <a href="{{ url controller='Member' action='SetAddrDefault' id=$addr.member_id add_id=$addr.add_id }}">设为默认</a> | 
                                {{/if}}
                                <a href="{{ url controller='Member' action='RemoveAddr' id=$addr.member_id add_id=$addr.add_id }}" onclick="remove_confirm('#listform', this); return(false);">删除</a>
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
<script type="text/javascript">
jQuery(function() {
    var prov_id = '{{$addrs.address.province.id}}';
    var city_id = '{{$addrs.address.city.id}}';
    if(prov_id&&city_id) {
        selectArea(prov_id, 'city', city_id);
    } else {
        selectArea(28, 'city', null);
    }
});
/* 选择 */
var selectArea = function(provId, displayId, current)
{
    if(displayId == 'division')
    {
        current = '{{$addrs.address.division.id}}';
    }
    $.post(
        "{{ url controller='Member' action='AjaxSelectArea' }}",
        {
            prov_id : provId,
            disp : displayId,
            current_id : current
        },
        function(data) {

            if(data){

                $("#"+displayId).html(data);

            } else {

                $("#"+displayId).html("<option value='0'>- 无 -</a>");
            }

            if(displayId == 'city') {

                selectArea($("#city").val(), 'division', current);

            }
            fixForm();
        }

    );
}

var fixForm = function()
{
    $("input[name='province[id]']").val($("#province").val());
    $("input[name='province[name]']").val($("#province option:selected").text());
    $("input[name='city[id]']").val($("#city").val());
    $("input[name='city[name]']").val($("#city option:selected").text());
    $("input[name='division[id]']").val($("#division").val());
    $("input[name='division[name]']").val($("#division option:selected").text());
}
</script>
</body>

</html>

