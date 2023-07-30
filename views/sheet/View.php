
<table class="table table-bordered">
    <?php foreach($data as $row): ?>
    <tr class="<?php echo ($row[1] == 'valid')? 'text-success':'text-danger' ?>">
        <td><?php echo $row[0] ?></td>
        <td><?php echo $row[1] ?></td>
    </tr>
    <?php endforeach; ?>
</table>