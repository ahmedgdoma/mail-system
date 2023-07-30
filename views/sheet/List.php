<?php use yii\helpers\Url;

$processed_files_dir = 'processedFiles/'; ?>
<table class="table table-bordered">
    <tr>
        <th>File Name</th>
        <th>View File Report</th>
        <th>Download File</th>
    </tr>
    <?php foreach($files as $file): ?>
    <?php
        $file = basename($file);
        $fileURL = Url::base(true). '/' . $processed_files_dir . $file;
        $viewURL = Url::to(['sheet/view', 'file' => $file]);
        ?>
    <tr>
        <td><?php echo $file ?></td>
        <td><a href="<?php echo $viewURL; ?>">View</a></td>
        <td><a href="<?php echo $fileURL ?>">Download</a></td>
    </tr>
    <?php endforeach; ?>
</table>