
<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

    <h1>Content Added Successfully</h1>
    <hr>
    <a href="<?= base_url('content/add') ?>">Add More Content</a>
