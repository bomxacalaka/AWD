<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
</head>
<body>
    <h1><?= $title; ?></h1>
    <h2>Welcome, <?= $name; ?></h2>
    <a href="<?= base_url('dashboard/profile'); ?>">Profile</a>
    <a href="<?= base_url('auth/logout'); ?>">Logout</a>
</body>
</html>