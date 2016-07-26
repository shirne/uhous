<?php
/**
 * 产品分类页面
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @author     Allen <movoin@gmail.com>
 * @version    $Id: Categories.php 2 2010-04-27 16:47:43Z allen $
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
getControl('Position', 'position', array('position' => '产品分类', 'column' => '栏目管理', 'footprint' => true));

// 载入命令菜单页面控件
getControl('Cmdmenu', 'cmd', array('items' => $data['cmdMenu'], 'visited' => 'Categories'));
?>

    <div class="layout clearfix mt">

        <div class="layout-left">
            <div class="box">
                <h3>产品分类</h3>
                <div class="tree-data">
<?php
// 载入栏目树控件
getControl(
    'Treedata',
    'tree-data',
    array(
        'items' => $data['allCategories'],
        'linkName' => '分类',
        'controller' => 'Product',
        'action' => 'Categories',
        'remove' => 'RemoveCategory',
        'pkv' => 'cate_id',
    )
);
?>

                </div>
            </div>
        </div>

        <div class="layout-right">

            <div class="box">
                <h3>编辑分类</h3>
                <div class="form">

                    <form id="editform" name="editform" action="<?php echo _url(currentController(), 'SaveCategory'); ?>" method="post">

                        <p>
                            <label for="parent_id">所属分类:</label>
                            <select id="parent_id" name="parent_id">
                                <option value="0">作为一级分类</option>
                                <?php foreach ($data['allCategories'] as $category): ?>
                                <option value="<?php echo $category['cate_id']; ?>"<?php echo $_GET['parent_id'] && $_GET['parent_id'] == $category['cate_id'] ? ' selected="selected"' : '';?>><?php echo $category['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </p>

                        <p>
                            <label for="name">分类名称:</label>
                            <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" id="name" name="name" type="text" value="<?php echo $data['row']['name']; ?>" /></b></b>
                        </p>

                        <p>
                            <label for="sort_id">显示位置:</label>
                            <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" id="sort_id" name="sort_id" type="text" value="<?php echo $data['row']['sort_id'] ? $data['row']['sort_id'] : 1; ?>" /></b></b>
                        </p>

                        <hr class="clearfix" />

                        <p class="clearfix">
                            <input class="ibtn ibtn-ok" type="submit" value="保存分类" />
                            <?php if ($data['row']['cate_id']): ?>
                            <input class="ibtn" type="button" value="删除分类" onclick="window.location.href='<?php echo _url(currentController(), 'RemoveCategory', array('cate_id' => $data['row']['cate_id'])); ?>'" />
                            <?php endif; ?>

                            <input type="hidden" id="cate_id" name="cate_id" value="<?php echo $data['row']['cate_id']; ?>" />
                            <input type="hidden" id="col_key" name="col_key" value="<?php echo $_GET['col_key']; ?>" />
                            <input type="hidden" id="lang" name="lang" value="<?php echo getLanguage(); ?>" />
                        </p>

                        <div class="clear"><!-- Clear Float --></div>

                    </form>

                </div>
            </div>

        </div>


        <div class="clear"><!-- Clear Float --></div>

    </div>

</div>

</body>

</html>
