{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='栏目管理' position='服务项列表' footprint='yes' }}

{{ assign var='cmdType' value='foods' }}

{{ include file='modules/merchant/cmd.tpl' }}

    <div class="layout clearfix">
    
        <div class="box" style="width: 22%; float: left; margin-right: 2%;">
            <h3><a class="btn btn-small-base fr" style="padding: 0px 4px; text-indent:0px; margin: 5px 10px 0 0; font-weight: normal;" href="{{ url controller='Merchant' action='Modify' merc_id=$merchantInfo.merc_id }}">编辑</a>{{ $merchantInfo.name }}</h3>
            <div class="form">
            <table>
                <tr>
                    <td colspan="2" class="tc" >
                        <p>
                            <b class="fluid-input"><b class="fluid-input-inner">
                            <img src="/{{ get_app_inf key='uploadDir' }}{{ $merchantInfo.logo }}" width="160px;" />
                            </b></b>
                        </p>
                    </td>
                </tr>
                <tr><td width="30%;" valign="top">联系电话：</td><td>{{ $merchantInfo.phone }}</td></tr>
                <tr><td width="30%;" valign="top">联系地址：</td><td>{{ $merchantInfo.address }}</td></tr>
                <tr>
                    <td colspan="2" class="{{ if $merchantInfo.pic }}tc{{ /if }}">
                        <p>
                            <b class="fluid-input"><b class="fluid-input-inner">
                            <img src="/{{ get_app_inf key='uploadDir' }}{{ $merchantInfo.pic }}" width="160px;" alt="地图" />
                            </b></b>
                        </p>
                    </td>
                </tr>
            </table>
            </div>
        </div>

        <div class="box" style="width: 75%; float: left; ">
            <h3>服务项列表</h3>
            <form id="listform" name="listform" action="{{ url controller='Merchant' action='RemoveFood' }}" method="post">
                <table class="table-data">
                    <thead>
                        <tr>
                            <th width="5%"><input id="checkall" name="checkall" type="checkbox" /></th>
                            <th width="20%">服务项名称</th>
                            <th width="12%">服务项类别</th>
                            <th width="18%">服务项图片</th>
                            <th width="10%">热门</th>
                            <th width="10%">创建日期</th>
                            <th>管理</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th><input class="ibtn" type="button" value="删除所选" onclick="remove_confirm('#listform', '')" /></th>
                            <th>
                                <input class="ibtn" type="button" value="设为热门" onclick="ctl_submit('#listform', '{{ url controller='Merchant' action='SetHot' hot=1 }}')" />
                                <input class="ibtn" type="button" value="取消热门" onclick="ctl_submit('#listform', '{{ url controller='Merchant' action='SetHot' hot=0 }}')" />
                            </th>
                            <th colspan="6">
{{ webcontrol type='Pagenav' name='pager' pager=$pager prevLabel='上一页' nextLabel='下一页' controller=$controller action=$action colkey=$colkey lang=$lang search=$search cate_id=$cate_id merc_id=$merchantInfo.merc_id}}
                            </th>
                        </tr>
                    </tfoot>
                    <tbody>
{{ foreach from=$foods item=food }}
                        <tr>
                            <td class="tc"><input id="check[]" name="check[]" type="checkbox" value="{{ $food.food_id }}" /></td>
                            <td><a href="{{ url controller='Merchant' action='ModifyFood' id=$food.food_id }}">{{ $food.name }}</a></td>
                            <td class="tc"><a href="{{ url controller='Merchant' action='Foods' cate_id=$food.cate_id merc_id=$merchantInfo.merc_id }}">{{ $food.category.name }}</a></td>
                            <td class="tc"><img src="/{{ get_app_inf key='uploadDir' }}{{ $food.pic }}" height="60" /></td>
                            <td class="tc">
                                {{ if $food.hot eq 1 }}
                                    <img src="/sysadm/img/hook.jpg" />
                                {{ /if }}
                            </td>
                            <td class="tc">{{ $food.created|date_format:'%Y-%m-%d' }}</td>
                            <td class="tc">
                                <a href="{{ url controller='Merchant' action='ModifyFood' merc_id=$merchantInfo.merc_id id=$food.food_id }}">编辑</a> | 
                                <a href="{{ url controller='Merchant' action='RemoveFood' merc_id=$merchantInfo.merc_id id=$food.food_id }}" onclick="remove_confirm('#listform', this); return(false);">删除</a>
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
