<h2>Add Data</h2>
<div class="container mt-5">
    <form action="<?= base_url('content/create') ?>" method="post">
        <!-- CSRF token field -->
        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

        <!-- Title input field -->
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <!-- Content input field -->
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" id="content" name="content" rows="4" required></textarea>
        </div>

        <!-- Submit button -->
        <button type="submit" class="btn btn-primary">Add Content</button>
    </form>
</div>


<a href="https://h.drbom.net/content"></a>