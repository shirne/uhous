<?php
/**
 * 网站设置页面
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @author     Allen <movoin@gmail.com>
 * @version    $Id: Setting.php 2 2010-04-27 16:47:43Z allen $
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
getControl('Position', 'position', array('position' => '网站设置', 'column' => '系统设置'));
?>

    <div class="layout clearfix mt">

        <div class="box">
            <h3>网站设置</h3>
            <div class="form">

                <form id="editform" name="editform" action="<?php echo $this->_url('Save'); ?>" method="post">

                    <p>
                        <label for="sitename">网站名称:</label>
                        <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" id="sitename" name="sitename" type="text" value="<?php echo getOption('sitename'); ?>" /></b></b>
                    </p>

                    <p>
                        <label for="domain">网站域名:</label>
                        <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" id="domain" name="domain" type="text" value="<?php echo getOption('domain') ? getOption('domain') : 'http://'; ?>" /></b></b>
                    </p>

                    <p>
                        <label for="keyword">默认关键字(还可以再输入 <span class="k-charsLeft">200</span> / 200 个字符):</label>
                        <b class="fluid-input"><b class="fluid-input-inner"><textarea class="itext keyword-limited" id="keyword" name="keyword"><?php echo getOption('keyword'); ?></textarea></b></b>
                        <input type="hidden" name="maxlength" value="200" />
                    </p>

                    <p>
                        <label for="description">网站描述(还可以再输入 <span class="d-charsLeft">200</span> / 200 个字符):</label>
                        <b class="fluid-input"><b class="fluid-input-inner"><textarea class="itext description-limited" id="description" name="description"><?php echo getOption('description'); ?></textarea></b></b>
                        <input type="hidden" name="maxlength" value="200" />
                    </p>

                    <p>
                        <label for="copyright">网站版权信息:</label>
                        <b class="fluid-input"><b class="fluid-input-inner">
                        <?php getControl('Editor', 'copyright', array('value' => getOption('copyright'), 'style' => 'Basic', 'height' => 100)); ?>

                        </b></b>
                    </p>

                    <p>
                        <label for="icp">ICP备案号:</label>
                        <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" id="icp" name="icp" type="text" value="<?php echo getOption('icp') ? getOption('icp') : '备案申请已提交'; ?>" /></b></b>
                    </p>

                    <hr class="clearfix" />

                    <p class="clearfix">
                        <input class="ibtn ibtn-ok" type="submit" value="保存设置" />
                    </p>

                    <div class="clear"><!-- Clear Float --></div>

                </form>

            </div>
        </div>


        <div class="clear"><!-- Clear Float --></div>

    </div>

</div>

<!-- 限制输入字数 -->
<script type="text/javascript" src="../themes/sysadm/js/jquery.maxlength.js"></script>
<script type="text/javascript">
$(function () {
        $('textarea.keyword-limited').maxlength({
            'feedback' : '.k-charsLeft', 'useInput' : true
        });
        $('textarea.description-limited').maxlength({
            'feedback' : '.d-charsLeft', 'useInput' : true
        });
    });
</script>

</body>

</html>
