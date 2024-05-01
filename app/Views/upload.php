<!-- View: upload.php -->
<?= \Config\Services::validation()->listErrors() ?>
<?= csrf_field() ?>
<?= form_open_multipart('/upload/do_upload') ?>
    <input type="file" name="profile_picture" />
    <button type="submit">Upload</button>
<?= form_close() ?>
