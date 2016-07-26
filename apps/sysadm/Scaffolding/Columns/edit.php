<?php include SCAFF_DIR . '/View/header.inc.php'; ?>

<div id="wrap">

<form action="<?php echo $this->_url('Save'); ?>" method="post">

    <div class="menu">
        <ul>
            <li><a href="<?php echo $this->_url(); ?>">List</a></li>
        </ul>
    </div>

    <br />


    <table>

        <caption><?php echo $this->_tdgName; ?></caption>

        <thead>
    	    <tr>
                <th scope="col" colspan="2">Create Column</th>
            </tr>
        </thead>

        <tfoot>

            <tr>
                <td scope="col" colspan="2"><input type="submit" value="Submit" /></td>
            </tr>

        </tfoot>

<?php if ($data['modules'] && !$_GET['col_id']): ?>

        <tr class="odd">
            <th scope="col" width="20%" style="text-align:right;">Enable Modules</th>
            <td scope="col" style="text-align:left;"><input type="checkbox" id="enable_mod" name="enable_mod" checked="checked" value="yes" onclick="swapMode(this)" /></td>
        </tr>

        <tbody id="modules">

            <tr>
                <th scope="col" style="text-align:right;">Set Modules</th>
                <td scope="col" style="text-align:left;">

                    <select id="mod" name="mod">

                    <?php foreach ($data['modules'] as $module): ?>

                        <option value="<?php echo $module['mod_id']; ?>"><?php echo $module['name']; ?></option>

                    <?php endforeach; ?>

                    </select>

                </td>
            </tr>

        </tbody>

<?php endif; ?>

        <tbody id="customize">

<?php if ($data['fields']): ?>

<?php foreach ($data['fields'] as $field => $value): ?>

    	<tr>
            <th scope="col" style="text-align:right;"><?php echo strtoupper($field); ?></th>
            <td scope="col" style="text-align:left;">
            <?php if ($field == 'parent_id'): ?>
            <select id="parent_id" name="parent_id">
                <option value="0">None</option>
                <?php if ($data['parents']): ?>
                <?php foreach ($data['parents'] as $parent): ?>
                <option value="<?php echo $parent['col_id']; ?>"<?php if ($parent['col_id'] == $value) { echo ' selected="selected"'; } ?>><?php echo $parent['name']; ?></option>
                <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <?php elseif ($field == 'lang'): ?>

            <?php $languages = FLEA::getAppInf('languages'); ?>

            <select id="lang" name="lang">
            <?php foreach ($languages as $v => $lang): ?>
                <option value="<?php echo $v; ?>"<?php if ($v == $value) { echo ' selected="selected"'; } ?>><?php echo $lang; ?></option>
            <?php endforeach; ?>
            </select>

            <?php else: ?>
            <input class="itext" type="text" name="<?php echo $field; ?>" id="<?php echo $field; ?>" value="<?php echo $value; ?>" />
            <?php endif; ?>
            </td>
        </tr>

<?php endforeach; ?>

<?php endif; ?>

        </tbody>

    </table>

</form>

</div>

<script type="text/javascript">

var $ = function(i) {
    return document.getElementById(i);
};

var swapMode = function(m) {
    if (m.checked) {
        $('modules').style.display = '';
    } else {
        $('modules').style.display = 'none';
    }
};

</script>

<?php include SCAFF_DIR . '/View/footer.inc.php'; ?>

