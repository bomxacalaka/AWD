<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation</title>
</head>
<body>
<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

    <h1>Content Added Successfully</h1>
    <a href="<?= base_url('content/add') ?>">Add More Content</a>
</body>
</html>
