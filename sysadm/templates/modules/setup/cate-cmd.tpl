    <div id="cmd">

        <a class="btn fr{{ if $cmdType == 'area' }} btn-on{{ /if }}" href="{{ url controller='Setup' action='Area'}}">地区列表</a>

        <a class="btn fl" href="{{ url controller='Setup' action='AddNewArea' }}">添加地区</a>
        <a class="btn fl" href="{{ url controller='Setup' action='SortAreas' }}">地区排序</a>


        <div class="clear"><!-- Clear Float --></div>
    </div>
