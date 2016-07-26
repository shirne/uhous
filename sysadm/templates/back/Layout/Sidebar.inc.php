<?php
/**
 * 侧边栏
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @author     Allen <movoin@gmail.com>
 * @version    $Id: Sidebar.inc.php 2 2010-04-27 16:47:43Z allen $
 **/
?>
<?php defined('IN_EOMS') or die ('Direct Access to this location is not allowed.'); ?>

<!--// Sidebar On West Panel -->
<div id="<?php echo $name; ?>">
    <div class="sidebar">
        <!-- 系统栏目 -->
        <h3><a href="#columns">栏目管理</a></h3>
        <div>
            <div class="sub-nav">
            </div>
        </div>
        <!-- 权限设置 -->
        <h3><a href="#permissions">权限管理</a></h3>
        <div>
            <div class="nav">
                <ul>
                    <li>
                        <a href="<?php echo _url('Admin', 'List'); ?>" target="inner-content">管理员管理</a>
                    </li>
                    <li>
                        <a href="<?php echo _url('Admin', 'Roles'); ?>" target="inner-content">角色管理</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- 功能栏目 -->
        <h3><a href="#system">系统设置</a></h3>
        <div>
            <div class="nav">
                <ul>
                    <li>
                        <a href="<?php echo _url('Setting'); ?>" target="inner-content">网站设置</a>
                    </li>
                    <li>
                        <a href="<?php echo _url('Generate'); ?>" target="inner-content">生成静态页面</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

