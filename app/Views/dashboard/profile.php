
    <h1>Profile</h1>
    
    <!-- Display flash messages (success or error) -->
    <?php if (session()->has('success')) : ?>
        <div style="color: green;"><?= session()->get('success') ?></div>
    <?php endif ?>
    <?php if (session()->has('error')) : ?>
        <div style="color: red;"><?= session()->get('error') ?></div>
    <?php endif ?>

    <!-- Display user's current profile picture (if available) -->
    <?php if ($userID) : ?>
        <img src="<?= base_url('pfp/' . $userID) ?>" alt="Profile Picture" width="200" height="200" style="border-radius: 50%;" />
    <?php endif ?>

<!-- View: upload.php -->
<?= \Config\Services::validation()->listErrors() ?>
<?= csrf_field() ?>
<?= form_open_multipart('/dashboard/profile/upload') ?>
    <input type="file" name="profile_picture" />
    <button type="submit">Upload</button>
<?= form_close() ?>

