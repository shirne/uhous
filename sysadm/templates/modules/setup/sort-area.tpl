{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='栏目管理' position='地区排序' footprint='yes' }}

{{ assign var='cmdType' value='area' }}

{{ include file='modules/setup/cate-cmd.tpl' }}

<!-- 排序JavaScript -->
<script type="text/javascript" src="/sysadm/js/sortselect.js"></script>

    <div class="layout clearfix mt">

        <form id="sortform" name="sortform" action="{{ url controller='Setup' action='SaveSortAreas' }}" method="post">

            <div class="layout-left">

                <div class="box">
                    <h3>地区</h3>
                    <div class="form">
                        <select id="sort" name="sort" size="26" style="width:100%" ondblclick="window.location.href='{{ url controller="Setup" action="SortAreas" }}&parent_id=' + $('#sort option:selected').val()">
{{ section name=category loop=$categories }}
                            <option value="{{$categories[category].cate_id}}">{{ $smarty.section.category.iteration }}.{{$categories[category].name}}</option>
{{ /section }}
                        </select>
                        <p>
                            <small>双击地区名称进行子地区排序</small>
                        </p>
                    </div>
                </div>

            </div>

            <div class="layout-right">

                <div class="box">
                    <h3>地区排序</h3>

                    <div class="form">

                        <p>
                            <label for="parent_id">选择排序地区</label>
                            <select id="parent_id" name="parent_id">
                                <option value="0">所有一级地区</option>

{{ foreach from=$topCategories item=top }}
                                <option value="{{$top.cate_id}}">{{$top.name}}</option>
{{ /foreach }}

                            </select>
                            <input class="ibtn" type="button" value="列出地区" 
                            onclick="window.location.href='{{ url controller="Setup" action="SortAreas" }}&parent_id=' + $('#parent_id option:selected').val()" />
                        </p>

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
