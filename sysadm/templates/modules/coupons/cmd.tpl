    <div id="cmd">

        <a class="btn fr{{ if $cmdType == 'coupon' }} btn-on{{ /if }}" href="{{ url controller='Coupons' action='Index' }}">优惠券列表</a>

        <a class="btn fl" href="{{ url controller='Coupons' action='AddNew' }}">添加优惠券</a>
        <a class="btn fl" href="{{ url controller='Coupons' action='Sort' }}">优惠券排序</a>

        <div class="clear"><!-- Clear Float --></div>
    </div>
