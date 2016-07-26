{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='系统设置' position='清空缓存' printfoot=false }}

    <div id="cmd">
        <a id="clearRuntime" class="btn fl" href="">开始清空数据缓存</a>
        <div class="clear"><!-- Clear Float --></div>
    </div>

    <div class="layout clearfix mt">

        <div class="box">
            <h3>清空缓存</h3>
            <div class="form">
                <b class="fluid-input"><b class="fluid-input-inner"><textarea id="log" name="log" class="itext" style="height: 400px;" readonly="readonly"></textarea></b></b>
            </div>
        </div>

        <div class="clear"><!-- Clear Float --></div>

    </div>

</div>

<script type="text/javascript">
$(document).ready(function(){
    // 清空数据缓存
    $('#clearRuntime').click(function() {
        $.post('{{ url controller="Settings" action="ClearCache" }}', {type: 'runtime'}, function(response) {
            $('#log').html(response);
            if (response.indexOf("SUCCESSED.") != -1) {
                alert('清理完成!');
            }
        });
        return(false);
    });
});
</script>

</body>

</html>

