<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body>
    <h1>Profile</h1>
    
    <!-- Display flash messages (success or error) -->
    <?php if (session()->has('success')) : ?>
        <div style="color: green;"><?= session()->get('success') ?></div>
    <?php endif ?>
    <?php if (session()->has('error')) : ?>
        <div style="color: red;"><?= session()->get('error') ?></div>
    <?php endif ?>

    <!-- Display user's current profile picture (if available) -->
    <?php if (isset($avatar)) : ?>
        <img src="<?= base_url('writable/uploads/' . $avatar) ?>" alt="Profile Picture">
    <?php endif ?>

    <!-- Upload form -->
    <form action="<?= base_url('profile/upload_picture') ?>" method="post" enctype="multipart/form-data">
        <input type="file" name="avatar" accept="image/*">
        <button type="submit">Upload</button>
    </form>
</body>
</html>
