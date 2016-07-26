{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ if $member.member_id }}

    {{ assign var='label' value='编辑会员' }}

{{ else }}

    {{ assign var='label' value='添加会员' }}

{{ /if }}

{{ webcontrol type='Position' name='position' column='栏目管理' position=$label footprint='yes' }}

{{ assign var='cmdType' value='member' }}

{{ include file='modules/members/cmd.tpl' }}

<div class="layout clearfix">

        <div class="box">
            <h3>{{$label}} - {{$member.username}}</h3>
            <div class="form">

                <form id="editform" name="editform" action="{{ url controller='Member' action='Save' }}" method="post">
                    <table>
                        <tr>
                           <td style="width: 30%;">
                                <p>
                                    <label for="level_id">会员等级:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <select id="level_id" name="level_id">
{{ foreach from=$levels item=cate }}
{{ if $cate.children }}
    <optgroup label="{{$cate.name}}">
    {{ foreach from=$cate.children item=child }}
        <option value="{{$child.level_id}}"{{ if $member.level_id == $child.level_id }} selected="selected"{{ /if }}>{{$child.levels}}</option>
    {{ /foreach }}
    </optgroup>
{{ else }}
    <option value="{{$cate.level_id}}"{{ if $member.level_id == $cate.level_id }} selected="selected"{{ /if }}>{{$cate.levels}}</option>
{{ /if }}
{{ /foreach }}
                                    </select>
                                    </b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <p>
                                    <label for="username">用户名称:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='textbox' name='username' value=$member.username class='itext' }}</b></b>
                                    <small>* 必填</small>
                                </p>
                            </td>
                            <td width="2%"></td>
                            <td width="22%">
                                <p>
                                    <label for="password">用户密码:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='textbox' name='password' class='itext' }}</b></b>
                                    <small>* 若要修改密码，请输入新密码</small>
                                </p>
                            </td>
                            <td width="2%"></td>
                            <td>
                                <p>
                                    <label for="points">积分:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                        <input id="points" class="itext" name="points" value="{{ if $member.points }}{{ $member.points }}{{ else }}{{ option key='default_points' }}{{ /if }}" />
                                    </b></b>
                                    <small>* 必填</small>
                                </p>
                            </td>
                            <td width="2%"></td>
                            <td>
                                <p>
                                    <label for="discount">折扣率:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='textbox' name='discount' value=$member.discount class='itext' }}</b></b>
                                    <small>请填写为0-100的整数,如填入80，则折扣率为8折</small>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="params[phone]">手机:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='textbox' name='params[phone]' value=$member.params.phone class='itext' }}</b></b>
                                </p>
                            </td>
                            <td></td>
                            <td>
                                <p>
                                    <label for="email">电子邮箱:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='textbox' name='email' value=$member.email class='itext' }}</b></b>
                                </p>
                            </td>
                            <td></td>
                            <td>
                                <p>
                                    <label for="params[qq]">QQ:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='textbox' name='params[qq]' value=$member.params.qq class='itext' }}</b></b>
                                </p>
                            </td>
                            <td></td>
                            <td>
                                <p>
                                    <label for="params[msn]">MSN:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='textbox' name='params[msn]' value=$member.params.msn class='itext' }}</b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="params[fax]">传真号码:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='textbox' name='params[fax]' value=$member.params.fax class='itext' }}</b></b>
                                </p>
                            </td>
                            <td></td>
                            <td>
                                <p>
                                    <label for="sex">性别:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <select id="sex" name="sex">
                                        <option {{if $member.sex eq 0}}selected="selected"{{/if}} value="0">保密</option>
                                        <option {{if $member.sex eq 1}}selected="selected"{{/if}} value="1">男</option>
                                        <option {{if $member.sex eq 2}}selected="selected"{{/if}} value="2">女</option>
                                    </select>
                                    </b></b>
                                </p>
                            </td>
                            <td></td>
                            <td>
                                <p>
                                    <label for="birthday">出生年月:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <select id="year" name="year">
                                        <script text="javascript">
                                            year = {{$member.year}};
                                            for( i = 1951; i<= 2012; i++) {
                                                item_year = "<option";
                                                if(year == i)
                                                {
                                                    item_year += " selected='selected'";
                                                }

                                                item_year += " value="+i+">"+i+"</option>";
                                                document.write(item_year);
                                            }
                                        </script>
                                    </select>
                                    <select id="month" name="month">
                                        <script text="javascript">
                                            month = {{$member.month}};
                                            for( i = 1; i<= 12; i++) {
                                                item_month = "<option";
                                                if(month == i)
                                                {
                                                    item_month += " selected='selected'";
                                                }

                                                item_month += " value="+i+">"+i+"</option>";
                                                document.write(item_month);
                                            }
                                        </script>
                                    </select>
                                    <select id="day" name="day">
                                        <script text="javascript">
                                            day = {{$member.day}};
                                            for( i = 1; i<= 31; i++) {
                                                item_day = "<option";
                                                if(day == i)
                                                {
                                                    item_day += " selected='selected'";
                                                }

                                                item_day += " value="+i+">"+i+"</option>";
                                                document.write(item_day);
                                            }
                                        </script>
                                    </select>
                                    </b></b>
                                </p>
                            </td>
                            <td></td>
                            <td>
                                <p>
                                    <label for="overage">账户余额:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='textbox' name='overage' value=$member.overage class='itext' disabled="disabled" }}</b></b>
                                    <small>不可修改</small>
                                </p>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="params[post]">邮政编码:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='textbox' name='params[post]' value=$member.params.post class='itext' }}</b></b>
                                </p>
                            </td>
                            <td></td>
                            <td>
                                <p>
                                    <label for="params[profession]">职业:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='textbox' name='email' value=$member.params.profession class='itext' }}</b></b>
                                </p>
                            </td>
                            <td></td>
                            <td>

                            </td>
                            <td></td>
                            <td>

                            </td>
                        </tr>
                        <tr>
                            <td colspan="7">
                                <p>
                                    <label for="address">联系地址:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='textbox' name='address' value=$member.address class='itext' }}</b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7">
                                <p>
                                    <label>优惠券:</label>
                                    <label>
                                        {{ foreach from=$hascoupons.type item='coup' }}
                                        {{$coup.count}}张 {{$coup.name}}，
                                        {{ /foreach }}
                                        {{ if $hascoupons.total }}共计价值：￥{{$hascoupons.total}}{{ /if }}
                                        &nbsp;&nbsp;&nbsp;
                                        <a href="javascript:void(0);" class="ibtn ibtn-ok" id="gift">赠他优惠券</a>
                                    </label>
                                </p>
                                <div id="giftFrame" style="width: 500px; height: 25px; display:none; ">
                                    选择卡种：
                                    <select id="cou_id">
                                        {{ foreach from=$coupons item='cou' }}
                                        <option rel="{{$cou.value}}" class="{{$cou.period}}" value="{{$cou.cou_id}}">{{$cou.name}} - ￥{{$cou.value}}</option>
                                        {{ /foreach }}
                                    </select>
                                    <a id="giftok" href="javascript:void(0);" class="ibtn ibtn-ok" style="">确定</a>&nbsp;&nbsp;<span id="gifttips" style="display: none;">已赠送</span>

                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <p>
                                    <input class="ibtn ibtn-ok" type="submit" value="保存" />
                                    <input id="member_id" name="member_id" type="hidden" value="{{$member.member_id}}" />
                                    <input id="col_key" name="col_key" type="hidden" value="{{$member.col_key}}" />
                                    <input id="lang" name="lang" type="hidden" value="{{$member.lang}}" />
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

<script type="text/javascript" >
    jQuery(function($) {
        var open = 1;
        $("#gift").click(function() {
            if(open) {
                $("#giftFrame").slideDown();
                open = 0;
            } else {
                $("#giftFrame").slideUp();
                open = 1; 
            }

        });
        $("#giftok").click(function() {
            var opt = $("#cou_id option:selected");
            if(confirm("确定要赠送 \"" + opt.text() + "\" 吗？")) {
                $.post(
                    "{{ url controller='Member' action='AjaxSendCoupon' }}",
                    {
                        member_id : {{$member.member_id}},
                        cou_id : opt.val(),
                        value : opt.attr('rel'),
                        invaluetime : opt.attr('class')
                    },
                    function (data)
                    {
                        if(data.success) {
                            $("#gifttips").fadeIn('slow', function() {
                                $(this).fadeOut(3000);
                                window.location.reload();
                            });
                        }
                    },
                    'json'
                );
            }
        });
    });
</script>
</body>

</html>

