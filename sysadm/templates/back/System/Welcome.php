<?php
/**
 * 欢迎页面 - 显示系统信息
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @author     Allen <movoin@gmail.com>
 * @version    $Id: Welcome.php 2 2010-04-27 16:47:43Z allen $
 **/
?>
<?php defined('IN_EOMS') or die ('Direct Access to this location is not allowed.'); ?>
<?php
// 载入头部页面
include FLEA::getAppInf('templatesDir') . '/Layout/Header.inc.php';
?>

<div class="inner-content">

    <div id="welcome">
        <h2>Welcome, Allen!</h2>
    </div>

    <div class="layout clearfix">

        <div class="box mt">
            <h3>系统信息</h3>
            <div class="note">
                <?php
                $os = explode(" ", php_uname());

                function getcon($varName)
                {
                    switch($res = get_cfg_var($varName))
                    {
                        case 0:
                            return '<span style="color: red">NO</span>';
                            break;
                        case 1:
                            return '<span style="color: green">YES</span>';
                            break;
                        default:
                            return $res;
                            break;
                    }
                }
                ?>
                <table>
                    <tr>
                        <th width="15%">主机名称</th>
                        <td width="35%"><?php echo $os[1]; ?></td>
                        <th width="15%">PHP运行方式</th>
                        <td width="35%"><?php echo strtoupper(php_sapi_name()); ?></td>
                    </tr>
                    <tr>
                        <th>服务器域名/IP地址</th>
                        <td><?php echo $_SERVER['SERVER_NAME']?> ( <?php echo @gethostbyname($_SERVER['SERVER_NAME']); ?> )</td>
                        <th>PHP版本</th>
                        <td><?php echo PHP_VERSION; ?></td>
                    </tr>
                    <tr>
                        <th>服务器操作系统</th>
                        <td><?php echo $os[0]; ?> <?php echo $os[2]; ?></td>
                        <th>运行于安全模式</th>
                        <td><?php echo getcon("safe_mode"); ?></td>
                    </tr>
                    <tr>
                        <th>服务器解译引擎</th>
                        <td><?php echo $_SERVER['SERVER_SOFTWARE']; ?></td>
                        <th>支持ZEND编译运行</th>
                        <td><?php echo (get_cfg_var("zend_optimizer.optimization_level")||get_cfg_var("zend_extension_manager.optimizer_ts")||get_cfg_var("zend_extension_ts")) ? '<span style="color: green">YES</span>' : '<span style="color: red">NO</span>'; ?></td>
                    </tr>
                    <tr>
                        <th>服务器端口</th>
                        <td><?php echo $_SERVER['SERVER_PORT']; ?></td>
                        <th>程序最长运行时间</th>
                        <td><?php echo getcon("max_execution_time"); ?>秒</td>
                    </tr>
                    <tr>
                        <th>服务器时间</th>
                        <td><?php echo date("Y年n月j日 H:i:s")?>&nbsp;北京时间：<?php echo gmdate("Y年n月j日 H:i:s",time()+8*3600)?></td>
                        <th>允许最大上传文件</th>
                        <td><?php echo getcon("upload_max_filesize"); ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="box mt">
            <h3>版权信息</h3>
            <div class="note">

            </div>
        </div>


        <div class="clear"><!-- Clear Float --></div>

    </div>

</div>

</body>

</html>
