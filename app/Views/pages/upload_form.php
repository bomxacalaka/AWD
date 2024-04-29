<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
</head>
<body>
    <form action="<?= base_url('upload/do_upload') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="file" name="file" />
        <button type="submit">Upload</button>
    </form>
</body>
</html>
