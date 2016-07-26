    <div id="cmd">

        <a class="btn fr{{ if $cmdType == 'advertise' }} btn-on{{ /if }}" href="{{ url controller='Advertise' action='Index' }}">广告列表</a>
        <a class="btn fr{{ if $cmdType == 'focus' }} btn-on{{ /if }}" href="{{ url controller='Advertise' action='Focus' }}">首页焦点图广告</a>

        <a class="btn fl" href="{{ url controller='Advertise' action='AddAdv' }}">添加广告</a>
        <a class="btn fl" href="{{ url controller='Advertise' action='SortAdvs' }}">广告排序</a>

        <div class="clear"><!-- Clear Float --></div>
    </div>
