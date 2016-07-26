<?php
/**
 * 栏目管理页面
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @author     Allen <movoin@gmail.com>
 * @version    $Id: Column.php 2 2010-04-27 16:47:43Z allen $
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
getControl('Position', 'position', array('column' => '系统设置', 'position' => '栏目管理'));
?>

    <div class="layout clearfix mt">

        <div class="layout-left">
            <div class="box">
                <h3>栏目列表</h3>
                <div class="tree-data">
<?php
// 载入栏目树控件
getControl('Treedata', 'tree-data', array('items' => $data['allColumns'], 'linkName' => '栏目', 'controller' => 'Column', 'pkv' => 'col_id'));
?>

                </div>
            </div>
        </div>

        <div class="layout-right">

            <div class="box">
                <h3>编辑栏目</h3>
                <div class="form">

                    <form id="editform" name="editform" action="<?php echo $this->_url('Save'); ?>" method="post">

                        <p>
                            <label for="parent_id">所属栏目:</label>
                            <select id="parent_id" name="parent_id">
                                <option value="0">作为一级栏目</option>
                                <?php foreach ($data['allColumns'] as $column): ?>
                                <option value="<?php echo $column['col_id']; ?>"<?php echo $_GET['parent_id'] && $_GET['parent_id'] == $column['col_id'] ? ' selected="selected"' : '';?>><?php echo $column['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </p>

                        <p>
                            <label for="module">应用模块:</label>
                            <?php getControl('Module', 'module', array('selected' => $data['row']['module'])); ?>
                        </p>

                        <p>
                            <label for="name">栏目名称:</label>
                            <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" id="name" name="name" type="text" value="<?php echo $data['row']['name']; ?>" /></b></b>
                        </p>

                        <p>
                            <label for="col_key">栏目别名:</label>
                            <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" id="col_key" name="col_key" type="text" value="<?php echo $data['row']['col_key']; ?>" /></b></b>
                        </p>

                        <p>
                            <label for="sort_id">显示位置:</label>
                            <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" id="sort_id" name="sort_id" type="text" value="<?php echo $data['row']['sort_id'] ? $data['row']['sort_id'] : 1; ?>" /></b></b>
                        </p>

                        <hr class="clearfix" />

                        <p class="clearfix">
                            <input class="ibtn ibtn-ok" type="submit" value="保存栏目" />
                            <?php if ($data['row']['col_id']): ?>
                            <input class="ibtn" type="button" value="删除栏目" onclick="window.location.href='<?php echo url('Column', 'Remove', array('col_id' => $data['row']['col_id'])); ?>'" />
                            <?php endif; ?>

                            <input type="hidden" id="col_id" name="col_id" value="<?php echo $data['row']['col_id']; ?>" />
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
