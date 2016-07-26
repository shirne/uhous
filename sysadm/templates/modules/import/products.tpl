{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='权限管理' position='产品批量导入' printfoot=false }}

    <div id="cmd">
        <a class="btn fl" href="{{ url controller='Import' action='Load' }}">预处理数据</a>
        <a class="btn fl" href="{{ url controller='Import' action='Products' }}">已导入的产品</a>
        <a class="btn fl" href="{{ url controller='Import' action='MakeThumb' }}">生成缩略图</a>
        <div class="clear"><!-- Clear Float --></div>
    </div>

    <div class="layout clearfix">

        <div class="box">
            <h3>产品列表</h3>
            <form id="listform" name="listform" action="{{ url controller='Admin' action='Remove' }}" method="post">
                <table class="table-data">
                    <thead>
                        <tr>
                            <th width="5%">ID</th>
                            <th width="25%">产品名称</th>
                            <th width="20%">分类</th>
                            <th width="15%">栏目</th>
                            <th width="35%">图片</th>
                        </tr>
                    </thead>
                    <tbody>
{{ foreach from=$rows item=row }}
                        <tr>
                            <td class="tc">{{$row.pro_id}}</td>
                            <td class="tc">{{$row.name}}</td>
                            <td class="tc">{{$row.cate_id}}</td>
                            <td class="tc">{{$row.col_key}}</td>
                            <td class="tc">{{$row.pic}}</td>
                        </tr>
{{ /foreach }}
                    </tbody>
                </table>
            </form>
        </div>

        <div class="clear"><!-- Clear Float --></div>

    </div>

</div>

</body>

</html>

