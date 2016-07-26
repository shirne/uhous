    <div id="cmd">

        <a class="btn fr{{ if $cmdType == 'information' }} btn-on{{ /if }}" href="{{ url controller='Information' action='Index' }}">信息列表</a>
        {{ if $smarty.get.colkey eq "info" }}
        <a class="btn fr{{ if $cmdType == 'information' }} btn{{ /if }}" href="{{ url controller='Information' action='Categories' }}">信息分类</a>
        {{ /if }}
        <a class="btn fl" href="{{ url controller='Information' action='AddNew' }}">发布信息</a>
        <a class="btn fl" href="{{ url controller='Information' action='Search' }}">搜索信息</a>

        <div class="clear"><!-- Clear Float --></div>
    </div>
