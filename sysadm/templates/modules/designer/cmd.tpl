    <div id="cmd">

        <a class="btn fr{{ if $cmdType == 'information' }} btn-on{{ /if }}" href="{{ url controller='Designer' action='Index' }}">设计师列表</a>
        <a class="btn fl" href="{{ url controller='Designer' action='AddNew' }}">添加设计师</a>
        <a class="btn fl" href="{{ url controller='Designer' action='Search' }}">搜索设计师</a>

        <div class="clear"><!-- Clear Float --></div>
    </div>
