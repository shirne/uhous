{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='权限管理' position='产品批量导入' printfoot=false }}

    <div id="cmd">
        <a class="btn fl" href="{{ url controller='Import' action='Load' }}">预处理数据</a>
        <a class="btn fl" href="{{ url controller='Import' action='Load' reload='yes' }}">重新扫描目录</a>
        <div class="clear"><!-- Clear Float --></div>
    </div>

    <div class="layout clearfix">

        <div class="box">
            <h3>产品列表</h3>
            <form id="listform" name="listform" action="{{ url controller='Admin' action='Remove' }}" method="post">
                <table class="table-data">
                    <thead>
                        <tr>
                            <th style="padding: 10px 0; text-align: left; padding-left: 12px;"><input class="ibtn" type="button" value="开始导入" onclick="window.location.href='{{ url controller='Import' action='Save' }}'" /></th>
                        </tr>
                    </thead>
                    <tbody>
{{ foreach from=$rows item=row }}
                        <tr>
                            <th class="tl">&nbsp;&nbsp;&nbsp;&nbsp;{{$row.name}} ( {{$row.dirName}} )</th>
                        </tr>
{{ foreach from=$row.files item=file }}
                        <tr>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp; |-- {{$file.name}} ( {{$row.dirName}}/{{$file.filename}} )</td>
                        </tr>
{{ /foreach }}
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

