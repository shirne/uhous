    <div id="cmd">

        <a class="btn fr{{ if $cmdType == 'setup' }} btn-on{{ /if }}" href="{{ url controller='Setup' action='Index' }}">{{$col_name}}列表</a>

        <a class="btn fl" href="{{ url controller='Setup' action='AddNew' }}">添加{{$col_name}}</a>
        <a class="btn fl" href="{{ url controller='Setup' action='Sort' }}">{{$col_name}}排序</a>

        <div class="clear"><!-- Clear Float --></div>
    </div>
