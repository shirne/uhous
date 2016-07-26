{{ include file='layouts/head.tpl' }}

<div class="inner-content">
{{ if $smarty.get.colkey eq 'payment' }}
{{ assign var='col_name' value='支付方式' }}
{{ else if $smarty.get.colkey eq 'delivery' }}
{{ assign var='col_name' value='配送方式' }}
{{ /if }}

{{ webcontrol type='Position' name='position' column='栏目管理' position=$col_name排序 footprint='yes' }}

{{ include file='modules/setup/cmd.tpl' }}

<!-- 排序JavaScript -->
<script type="text/javascript" src="/sysadm/js/sortselect.js"></script>

    <div class="layout clearfix mt">

        <form id="sortform" name="sortform" action="{{ url controller='Setup' action='SaveSort' }}" method="post">

            <div class="layout-left">

                <div class="box">
                    <h3>{{$col_name}}</h3>
                    <div class="form">
                        <select id="sort" name="sort" size="26" style="width:100%">
                        {{ section name=setup loop=$setups }}
                            <option value="{{ $setups[setup].set_id}}">{{ $smarty.section.setup.iteration }}.{{ $setups[setup].name}}</option>
                        {{ /section }}
                        </select>
                    </div>
                </div>

            </div>

            <div class="layout-right">

                <div class="box">
                    <h3>{{$col_name}}排序</h3>

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
