    <div id="cmd">

        <a class="btn fr{{ if $cmdType == 'member' }} btn-on{{ /if }}" href="{{ url controller='Member' action='Index' }}">会员列表</a>
        <a class="btn fr{{ if $cmdType == 'level' }} btn-on{{ /if }}" href="{{ url controller='Member' action='Level' }}">会员等级管理</a>
        <a class="btn fr{{ if $cmdType == 'setup' }} btn-on{{ /if }}" href="{{ url controller='Member' action='Setup' }}">属性设置</a>

{{ if $cmdType == 'member' }}
        <a class="btn fl" href="{{ url controller='Member' action='AddNew' }}">添加会员</a>
        <a class="btn fl" href="{{ url controller='Member' action='Search' }}">搜索会员</a>
{{ elseif $cmdType == 'level' }}
        <a class="btn fl" href="{{ url controller='Member' action='AddNewLevel' }}">添加会员等级</a>
        <a class="btn fl" href="{{ url controller='Member' action='SortLevels' }}">会员等级排序</a>
{{ /if }}

        <div class="clear"><!-- Clear Float --></div>
    </div>
