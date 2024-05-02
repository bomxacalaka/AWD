<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

<form method="post" action="<?= base_url('content/add') ?>">
    <label for="content">Content:</label><br>
    <textarea id="content" name="content" rows="4" cols="50"></textarea><br>
    <input type="submit" value="Submit">
</form>
