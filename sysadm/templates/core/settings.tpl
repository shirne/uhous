{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ webcontrol type='Position' name='position' column='系统管理' position='网站设置' printfoot=false }}

    <div class="layout clearfix mt">

        <div class="box">
            <h3>网站设置</h3>
            <div class="form">

                <form id="editform" name="editform" action="{{ url controller='Settings' action='Save' }}" method="post">
                    <table>
                        <tr>
                            <td>
                                <p>
                                    <label for="sitename">网站名称:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="sitename" name="sitename" value="{{ option key='sitename' }}" /></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="domain">网站域名:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="domain" name="domain" value="{{ option key='domain' }}" /></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="email">系统邮箱:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="email" name="email" value="{{ option key='email' }}" /></b></b>
                                    <small>请输入完整的邮箱地址</small>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="pass">邮箱密码:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="pass" name="pass" value="{{ option key='pass' }}" /></b></b>
                                    <small>系统邮箱对应密码</small>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="smtp">SMTP服务器地址:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="smtp" name="smtp" value="{{ option key='smtp' }}" /></b></b>
                                    <small>系统邮箱对应的SMTP服务器地址。</small>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="port">发送端口:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="port" name="port" value="{{ option key='port' }}" /></b></b>
                                    <small>SMTP服务器地址对应的端口。</small>
                                </p>
                            </td>
                        </tr>
						
						<tr>
                            <td>
                                <p>
                                    <label for="email">订单提醒邮箱:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="tipemail" name="tipemail" value="{{ option key='tipemail' }}" /></b></b>
                                    <small>请输入完整的邮箱地址</small>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="email">调度接口密码:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="jobencrypt" name="jobencrypt" value="{{ option key='jobencrypt' }}" /></b></b>
                                    <small>非管理人员请勿修改此项，如修改，需同时修改调度文件。越复杂越好</small>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="title">网站标题:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><textarea class="itext" id="title" name="title" style="height: 16px;">{{ option key='title' }}</textarea></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="keyword">网站关键字:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><textarea class="itext" id="keyword" name="keyword">{{ option key='keyword' }}</textarea></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="description">网站描述:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><textarea class="itext" id="description" name="description">{{ option key='description' }}</textarea></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="icp">ICP备案号:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="icp" name="icp" value="{{ option key='icp' }}" /></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="copyright">页尾版权信息:</label>
                                    {{ webcontrol type='Editor' name='copyright' value=$copyright style='Basic' height='120' }}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <input class="ibtn ibtn-ok" type="submit" value="保存设置" />
                                </p>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>

        <div class="clear"><!-- Clear Float --></div>

    </div>

</div>

</body>

</html>

