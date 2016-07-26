<?php
/**
 * 产品分类排序页面
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @author     Allen <movoin@gmail.com>
 * @version    $Id: SortCategories.php 2 2010-04-27 16:47:43Z allen $
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
getControl('Position', 'position', array('position' => '分类排序', 'column' => '栏目管理', 'footprint' => true));

// 载入命令菜单页面控件
getControl('Cmdmenu', 'cmd', array('items' => $data['cmdMenu'], 'visited' => 'SortCategories'));
?>

<!-- 排序JavaScript -->
<script type="text/javascript" src="../themes/sysadm/js/sortselect.js"></script>

    <div class="layout clearfix mt">

        <form id="sortform" name="sortform" action="<?php echo _url(currentController(), 'SaveCategoriesSort'); ?>" method="post">

            <div class="layout-left">

                <div class="box">
                    <h3><?php echo $data['column']['name']; ?> &rsaquo; 分类</h3>
                    <div class="form">
                        <select id="sort" name="sort" size="30" style="width:100%" ondblclick="window.location.href='<?php echo _url(currentController(), 'SortCategories'); ?>&parent_id=' + $('#sort option:selected').val()">
                        <?php if ($data['rows']): ?>

                        <?php foreach ($data['rows'] as $i => $row): ?>
                            <option value="<?php echo $row['cate_id']; ?>"><?php echo $i+1 . '.' . $row['name']; ?></option>
                        <?php endforeach; ?>

                        <?php endif; ?>
                        </select>
                        <p>
                        	<small>双击分类名称进行子分类排序</small>
                        </p>
                    </div>
                </div>

            </div>

            <div class="layout-right">

                <div class="box">
                    <h3>分类排序</h3>

                    <div class="form">

                        <p>
                        	<label for="parent_id">选择排序分类</label>
                            <select id="parent_id" name="parent_id">
                                <option value="0">所有一级分类</option>
                            <?php if ($data['parents']): ?>

                            <?php foreach ($data['parents'] as $i => $row): ?>
                                <option value="<?php echo $row['cate_id']; ?>"><?php echo $row['name']; ?></option>
                            <?php endforeach; ?>

                            <?php endif; ?>
                            </select>
                            <input class="ibtn" type="button" value="列出分类" 
                            onclick="window.location.href='<?php echo _url(currentController(), 'SortCategories'); ?>&parent_id=' + $('#parent_id option:selected').val()" />
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
