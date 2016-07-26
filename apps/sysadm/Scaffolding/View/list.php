<?php include 'header.inc.php'; ?>

<div id="wrap">

    <div class="menu">
        <ul>
            <li><a href="<?php echo $this->_url('Create'); ?>">+ Create Row</a></li>
        </ul>
    </div>

    <br />

    <table>

        <caption><?php echo $this->_tdgName; ?></caption>

        <thead>
    	    <tr>
            <?php if ($data['fields']): ?>
            <?php foreach ($data['fields'] as $field): ?>
                <th scope="col"><?php echo $field; ?></th>
            <?php endforeach; ?>
            <?php endif; ?>
                <th scope="col">MANAGEMENT</th>
            </tr>
        </thead>

        <tfoot>
            <tr>
                <th scope="col">Page:</th>
                <td colspan="<?php echo count($data['fields']); ?>" class="pager">
                    <a href="">1</a>
                </td>
            </tr>
        </tfoot>

<?php if ($data['rows']): ?>

<?php $i = 1; ?>

<?php foreach ($data['rows'] as $row): ?>

<?php
$class = '';
if ($i % 2 == 0) {
    $class = ' class="odd"';
}
?>
        <tr<?php echo $class; ?>>

<?php foreach ($data['fields'] as $field): ?>

            <td><?php echo $row[strtolower($field)]; ?></td>

<?php endforeach; ?>

    		<td><a href="<?php echo $this->_url('Edit', array($data['pkv'] => $row[$data['pkv']])); ?>" title="Edit">Edit</a> | <a href="<?php echo $this->_url('Delete', array($data['pkv'] => $row[$data['pkv']])); ?>" title="Delete">Delete</a></td>
        </tr>

<?php $i++; ?>

<?php endforeach; ?>

<?php endif; ?>

    </table>

</div>

<?php include 'footer.inc.php'; ?>

