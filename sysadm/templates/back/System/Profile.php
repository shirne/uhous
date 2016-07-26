<?php
/**
 * 管理员密码修改页面
 *
 * @copyright  Copyright (c) 2009 - 2010 6PiMa Network Technology Co., Ltd. <http://www.6pima.com>
 * @license    GNU General Public License 2.0 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 * @author     Allen <movoin@gmail.com>
 * @version    $Id: Profile.php 2 2010-04-27 16:47:43Z allen $
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
getControl('Position', 'position', array('position' => '管理员密码修改', 'column' => '系统设置'));
?>

    <div class="layout clearfix mt">

        <div class="box">
            <h3>管理员密码修改</h3>
            <div class="form">

                <form id="editform" name="editform" action="<?php echo $this->_url('Save'); ?>" method="post">

                    <input type="hidden" id="id" name="id" value="<?php echo $data['row']['id']; ?>" />

                    <p>
                        <label for="username">登录名称:</label>
                        <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" id="username" name="username" type="text" value="<?php echo $data['row']['username']; ?>" /></b></b>
                    </p>

                    <p>
                        <label for="password">登录密码:</label>
                        <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" id="password" name="password" type="password" value="" /></b></b>
                    </p>

                    <hr class="clearfix" />

                    <p class="clearfix">
                        <input class="ibtn ibtn-ok" type="submit" value="保存修改" />
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
