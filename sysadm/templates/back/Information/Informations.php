<?php
/**
 * 信息列表页面
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @author     Allen <movoin@gmail.com>
 * @version    $Id: Informations.php 2 2010-04-27 16:47:43Z allen $
 **/
?>
<?php defined('IN_CMS') or die ('Direct Access to this location is not allowed.'); ?>
<?php
// 载入头部页面
include FLEA::getAppInf('templatesDir') . '/Layout/Header.inc.php';
?>

<div class="inner-content">

<?php
// 载入Purr消息提示控件
getControl('Purr', 'tip', array('message' => $data['tip']));

// 载入当前位置页面控件
getControl('Position', 'position', array('position' => '信息列表', 'column' => '栏目管理', 'footprint' => true));

// 载入命令菜单页面控件
getControl('Cmdmenu', 'cmd', array('items' => $data['cmdMenu'], 'visited' => 'Index'));
?>

    <div class="layout clearfix mt">

        <div class="box">
            <h3>信息列表</h3>
            <form id="listform" name="listform" action="<?php echo _url(currentController(), 'Remove'); ?>" method="post">

<?php
// 载入表格数据页面控件
getControl('Tabledata', 'table-data', array('config' => $data['tableDataConfig']));
?>

            </form>

        </div>

        <div class="clear"><!-- Clear Float --></div>

    </div>

</div>

</body>

</html>

