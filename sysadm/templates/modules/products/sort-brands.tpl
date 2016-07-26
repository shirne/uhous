{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='栏目管理' position='品牌排序' footprint='yes' }}

{{ assign var='cmdType' value='brands' }}

{{ include file='modules/products/cmd.tpl' }}

<!-- 排序JavaScript -->
<script type="text/javascript" src="/sysadm/js/sortselect.js"></script>

    <div class="layout clearfix mt">

        <form id="sortform" name="sortform" action="{{ url controller='Products' action='SaveSortBrands' }}" method="post">

            <div class="layout-left">

                <div class="box">
                    <h3>品牌</h3>
                    <div class="form">
                        <select id="sort" name="sort" size="26" style="width:100%">
{{ section name=brand loop=$brands }}
                            <option value="{{$brands[brand].brand_id}}">{{ $smarty.section.brand.iteration }}.{{$brands[brand].name}}</option>
{{ /section }}
                        </select>
                    </div>
                </div>

            </div>

            <div class="layout-right">

                <div class="box">
                    <h3>品牌排序</h3>

                    <div class="form">

                        <p>
                            <fieldset>
                                <legend>排序操作</legend>
                                <div class="tc"><input class="ibtn" type="button" value="置顶" onclick="sl.fnFirst()" /></div>
                                <div class="tc"><input class="ibtn" type="button" value="上移" onclick="sl.sortUp()" /> <input class="ibtn" type="button" value="下移" onclick="sl.sortDown()" /></div>
                                <div class="tc"><input class="ibtn" type="button" value="置底" onclick="sl.fnEnd()" /></div>
                            </fieldset>
                        </p>

                        <hr class="clearfix" />

                        <p class="clearfix">
                            <input class="ibtn ibtn-ok" type="submit" value="保存排序结果" onclick="sl.ok()" />
                            <input type="hidden" id="seqNoList" name="seqNoList" />
                        </p>

                    </div>

                </div>

            </div>

            <div class="clear"><!-- Clear Float --></div>

        </form>

        <script type="text/javascript">
            var sl = new SortSelect("sortform", "sort", "search", "jumpNum");
        </script>

    </div>

</div>

</body>

</html>
