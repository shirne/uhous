<?php
/**
 * 图片编辑页面
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @author     Allen <movoin@gmail.com>
 * @version    $Id: Editor.php 2 2010-04-27 16:47:43Z allen $
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

$position = $_GET['pic_id'] ? '编辑图片' : '上传图片';

// 载入当前位置页面控件
getControl('Position', 'position', array('position' => $position, 'column' => '栏目管理', 'footprint' => true));

// 载入命令菜单页面控件
getControl('Cmdmenu', 'cmd', array('items' => $data['cmdMenu'], 'visited' => 'Create'));
?>

    <div class="layout clearfix mt">

        <div class="box">
            <h3><?php echo $position; ?></h3>
            <div class="form">

                <form id="editform" name="editform" action="<?php echo _url(currentController(), 'Save'); ?>" method="post" enctype="multipart/form-data">

                    <p>
                        <label for="title">图片标题:</label>
                        <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="title" name="title" value="<?php echo $data['row']['title']; ?>" /></b></b>
                    </p>

                    <p>
                        <label for="pic">上传图片:</label>
<?php if ($data['row']['pic']): ?>
<div>
    <img src="../<?php echo FLEA::getAppInf('uploadDir') . $data['row']['pic']; ?>" width="32" height="32" />
    <a href="../<?php echo FLEA::getAppInf('uploadDir') . $data['row']['pic']; ?>" target="_blank">查看原图</a> | <a href="<?php echo _url(currentController(), 'RemovePic', array('pic_id' => $data['row']['pic_id'])); ?>">删除图片</a>
</div>
<small>如需要重新上传图片，须先删除图片。</small>
<?php else: ?>
                        <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="file" id="pic" name="pic" /></b></b>
<?php endif; ?>
                    </p>

                    <p>
                        <label for="memo">图片说明:</label>
                        <b class="fluid-input"><b class="fluid-input-inner">
                        <?php getControl('Editor', 'memo', array('value' => $data['row']['memo'], 'style' => 'Basic')); ?>

                        </b></b>
                    </p>

                    <p>
                        <fieldset>
                            <legend>SEO相关</legend>
                            <div>
                                <p>
                                    <label for="seo_title">(页面标题)Title:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" id="seo_title" name="seo_title" type="text" value="<?php echo $data['row']['seo_title']; ?>" /></b></b>
                                </p>
                                <p>
                                    <label for="keyword">(关键字)Keyword:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><textarea class="itext" id="keyword" name="keyword"><?php echo $data['row']['keyword']; ?></textarea></b></b>
                                </p>
                                <p>
                                    <label for="description">(描述)Description:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><textarea class="itext" id="description" name="description"><?php echo $data['row']['description']; ?></textarea></b></b>
                                </p>
                            </div>
                        </fieldset>
                    </p>

                    <hr class="clearfix" />

                    <p class="clearfix">
                        <input class="ibtn ibtn-ok" type="submit" value="保存图片" />

                        <input type="hidden" id="col_key" name="col_key" value="<?php echo $data['column']['col_key']; ?>" />
                        <input type="hidden" id="lang" name="lang" value="<?php echo getLanguage(); ?>" />
                        <input type="hidden" id="pic_id" name="pic_id" value="<?php echo $data['row']['pic_id']; ?>" />
                    </p>

                    <div class="clear"><!-- Clear Float --></div>

                </form>

            </div>
        </div>


        <div class="clear"><!-- Clear Float --></div>

    </div>

</div>

</body>

</html>
