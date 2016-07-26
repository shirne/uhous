<?php
/**
 * 布局页面
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @author     Allen <movoin@gmail.com>
 * @version    $Id: Main.php 2 2010-04-27 16:47:43Z allen $
 **/
?>
<?php defined('IN_EOMS') or die ('Direct Access to this location is not allowed.'); ?>

<?php
// 载入头部页面
include FLEA::getAppInf('templatesDir') . '/Layout/Header.inc.php';
?>

    <!--// Header On North Panel -->
    <div id="header">
        <div id="user-panel">
            <p>你好, Allen <a href="<?php echo url('Admin', 'Profile'); ?>" target="inner-content">修改密码</a> | <a href="<?php echo url('Admin', 'Logout'); ?>">退出系统</a></p>
            <a class="btn" href="../" title="查看网站">查看网站</a>
            <div class="clear"><!-- Clear Float --></div>
        </div>
        <h1 id="logo"><a class="pngicon" href="<?php echo _url('Dashboard'); ?>" title="返回控制台">Six Horses</a></h1>
        <div class="clear"><!-- Clear Float --></div>
    </div>

<?php
// 载入侧边栏页面
getControl('Sidebar', 'sidebar');
?>

    <!--// Content On Center Panel -->
    <div id="content">
        <iframe id="inner-content" name="inner-content" src="<?php echo _url('Dashboard', 'Welcome'); ?>"></iframe>
    </div>

    <!--// Footer On South Panel -->
    <div id="footer" class="clearfix">

        <div id="languages">
            <?php
            // 载入侧边栏页面
            getControl('Languages', getLanguage());
            ?>

        </div>

        <div id="quicklink">
            <label>快速通道:</label>
            <div>
                <ul>
                    <li><a class="btn" href="" title="生成首页" target="inner-content">生成首页</a></li>
                    <li><a class="btn" href="" title="生成栏目页" target="inner-content">生成栏目页</a></li>
                    <li><a class="btn" href="" title="生成内容页" target="inner-content">生成内容页</a></li>
                </ul>
            </div>
        </div>

    </div>

</body>

</html>

