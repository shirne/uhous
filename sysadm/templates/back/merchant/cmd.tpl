    <div id="cmd">


{{ if $cmdType == 'foods' }}
        <a class="btn fr{{ if $cmdType == 'foods' }} btn-on{{ /if }}" href="{{ url controller='Merchant' action='Foods' merc_id=$smarty.get.merc_id }}">服务项列表</a>

        <a class="btn fl" href="{{ url controller='Merchant' action='AddNewFood' merc_id=$smarty.get.merc_id }}">添加服务项</a>
        <a class="btn fl" href="{{ url controller='Merchant' action='SortFood' merc_id=$smarty.get.merc_id }}">服务项排序</a>
        <a class="btn fl" href="{{ url controller='Merchant' action='SearchFood' merc_id=$smarty.get.merc_id }}">服务项搜索</a>
{{ /if }}

        <a class="btn fr{{ if $cmdType == 'merchant' }} btn-on{{ /if }}" href="{{ url controller='Merchant' colkey='merchant' }}">商家列表</a>

        <a class="btn fr{{ if $cmdType == 'categories' }} btn-on{{ /if }}" href="{{ url controller='Merchant' action='Category' col_key='merchant' }}">分类列表</a>
        <a class="btn fr{{ if $cmdType == 'business' }} btn-on{{ /if }}" href="{{ url controller='Merchant' action='Business' col_key='merchant' }}">行业列表</a>
        <a class="btn fr{{ if $cmdType == 'area' }} btn-on{{ /if }}" href="{{ url controller='Merchant' action='Area' col_key='merchant'  }}">区域列表</a>
        <a class="btn fr{{ if $cmdType == 'street' }} btn-on{{ /if }}" href="{{ url controller='Merchant' action='Street' col_key='merchant'  }}">街道列表</a>

{{ if $cmdType == 'merchant' }}
        <a class="btn fl" href="{{ url controller='Merchant' action='AddNew' }}">添加商家</a>
        <a class="btn fl" href="{{ url controller='Merchant' action='Search' }}">商家搜索</a>
        <a class="btn fl" href="{{ url controller='Merchant' action='Sort' }}">商家排序</a>
{{ elseif $cmdType == 'categories' }}
        <a class="btn fl" href="{{ url controller='Merchant' action='AddNewCategory' }}">添加分类</a>
        <a class="btn fl" href="{{ url controller='Merchant' action='SortCategories' }}">分类排序</a>
{{ elseif $cmdType == 'area' }}
        <a class="btn fl" href="{{ url controller='Merchant' action='AddNewArea' }}">添加区域</a>
        <a class="btn fl" href="{{ url controller='Merchant' action='SortArea' }}">区域排序</a>
{{ elseif $cmdType == 'street' }}
        <a class="btn fl" href="{{ url controller='Merchant' action='AddNewStreet' }}">添加街道</a>
        <a class="btn fl" href="{{ url controller='Merchant' action='SortStreet' }}">街道排序</a>
{{ elseif $cmdType == 'business' }}
        <a class="btn fl" href="{{ url controller='Merchant' action='AddNewBusiness' }}">添加行业</a>
        <a class="btn fl" href="{{ url controller='Merchant' action='SortBusiness' }}">行业排序</a>
{{ /if }}

        <div class="clear"><!-- Clear Float --></div>
    </div>
