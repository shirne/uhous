    <div id="cmd">

        <a class="btn fr{{ if $cmdType == 'brands' }} btn-on{{ /if }}" href="{{ url controller='Products' action='Brands' colkey='products' }}">品牌列表</a>
        <a class="btn fr{{ if $cmdType == 'categories' }} btn-on{{ /if }}" href="{{ url controller='Products' action='Categories' colkey='products'}}">分类列表</a>
        <a class="btn fr{{ if $cmdType == 'products' }} btn-on{{ /if }}" href="{{ url controller='Products' action='Index' colkey='products'}}">商品列表</a>


{{ if $cmdType == 'products' }}
        <a class="btn fl" href="{{ url controller='Products' action='AddNew' }}">添加商品</a>
        <a class="btn fl" href="{{ url controller='Products' action='Search' }}">商品搜索</a>
        <a class="btn fl" href="{{ url controller='Products' action='Sort' }}">商品排序</a>
{{ elseif $cmdType == 'categories' }}
        <a class="btn fl" href="{{ url controller='Products' action='AddNewCategory' }}">添加分类</a>
        <a class="btn fl" href="{{ url controller='Products' action='SortCategories' }}">分类排序</a>
{{ elseif $cmdType == 'brands' }}
        <a class="btn fl" href="{{ url controller='Products' action='AddNewBrand' }}">添加品牌</a>
        <a class="btn fl" href="{{ url controller='Products' action='SortBrands' }}">品牌排序</a>
{{ elseif $cmdType == 'advertise' }}
        <a class="btn fl" href="{{ url controller='Advs' action='AddAdv' }}">添加广告</a>
        <a class="btn fl" href="{{ url controller='Advs' action='SortAdv' }}">广告排序</a>
{{ elseif ($smarty.get.do neq 'attribute') and ($cmdType == 'attribute') }}
        <!--<a class="btn fl" href="{{ url controller='Products' action='AddNewAttrCate' }}">添加属性项</a>-->
        <a class="btn fl" href="{{ url controller='Products' action='SortAttrCates' }}">属性项排序</a>
{{ elseif $cmdType == 'comments' }}
{{ /if }}

        <div class="clear"><!-- Clear Float --></div>
    </div>
