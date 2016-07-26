    <div id="cmd">

        <a class="btn fl" href="{{ url controller='Exchange' action='AddPrize' }}">添加物品</a>
        <a class="btn fl" href="{{ url controller='Exchange' action='SearchPrize' }}">物品搜索</a>
        <a class="btn fl" href="{{ url controller='Exchange' action='Search' }}">兑换搜索</a>

        <a class="btn fr {{ if $cmdType eq 'prize' }}btn-on{{ /if }}" href="{{ url controller='Exchange' action='Prize' }}">物品列表</a>
        <a class="btn fr {{ if $cmdType eq 'exchange' }}btn-on{{ /if }}" href="{{ url controller='Exchange' }}">兑换列表</a>

        <div class="clear"><!-- Clear Float --></div>
    </div>
