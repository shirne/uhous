<?php include 'header.inc.php'; ?>

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
                <th scope="col" colspan="2">Create Row</th>
            </tr>
        </thead>

        <tfoot>

            <tr>
                <td scope="col" colspan="2"><input type="submit" value="Submit" /></td>
            </tr>

        </tfoot>

<?php if ($data['fields']): ?>

<?php foreach ($data['fields'] as $field => $value): ?>

    	<tr>
            <th scope="col" width="20%" style="text-align:right;"><?php echo strtoupper($field); ?></th>
            <td scope="col" style="text-align:left;"><input class="itext" type="text" name="<?php echo $field; ?>" id="<?php echo $field; ?>" value="<?php echo $value; ?>" /></td>
        </tr>

<?php endforeach; ?>

<?php endif; ?>

    </table>

</form>

</div>

<?php include 'footer.inc.php'; ?>

