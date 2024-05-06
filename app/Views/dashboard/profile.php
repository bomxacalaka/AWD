<head>
  <style>
        .btn-primary {
      width: 100%;
      padding: 10px;
      background-color: #000;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
  </style>
</head>
<div class="container">
    <div class="row justify-content-between align-items-center col-md-6">
        <div class="col-auto">
            <a href="/dashboard" class="btn btn-secondary">Back</a>
        </div>
        <h1 class="mb-4">Profile</h1>
        <hr>
        <!-- Display flash messages (success or error) -->
        <?php if (session()->has('success')) : ?>
            <div class="alert alert-success"><?= session()->get('success') ?></div>
        <?php endif ?>
        <?php if (session()->has('error')) : ?>
            <div class="alert alert-danger"><?= session()->get('error') ?></div>
        <?php endif ?>

        <!-- Display user's current profile picture (if available) -->
        <?php if ($userID) : ?>
            <img src="<?= base_url('pfp/' . $userID) ?>" class="img-fluid rounded mb-4" alt="Profile Picture" width="200" height="200">
        <?php endif ?>

        <!-- File upload form -->
        <form id="uploadForm" action="/dashboard/profile/upload" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="profile_picture" class="form-label">Choose Profile Picture</label>
                <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*">
                <span id="fileError" class="text-danger" style="display: none;">Invalid file format or size</span>
            </div>

            <!-- add space between submit and delete button -->
            <button type="submit" class="btn btn-primary">Upload</button>
            <div style="height: 10px;"></div>
            <!-- Delete account -->
        </form>
        <button type="button" class="btn btn-danger" onclick="confirmDelete()">Delete Account</button>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="deleteConfirmationModalLabel">Delete Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-danger">
                Are you sure you want to delete your account? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="deleteAccount()">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Custom JavaScript for file upload validation -->
<script>
    document.getElementById('uploadForm').addEventListener('submit', function(event) {
        var fileInput = document.getElementById('profile_picture');
        var file = fileInput.files[0];
        if (file.size > 2024 * 2024 || !['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'].includes(file.type)) {
            event.preventDefault();
            document.getElementById('fileError').style.display = 'block';
        }
    });

    // Function to show confirmation modal for account deletion
    function confirmDelete() {
        var modal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'), {
            keyboard: false
        });
        modal.show();
    }

    // Function to handle account deletion
    function deleteAccount() {
        // Perform account deletion here
        window.location.href = "/dashboard/profile/delete";
    }
</script>