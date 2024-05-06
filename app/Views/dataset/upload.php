<head>
  <style>
        .btn-short {
      width: 40%;
    }
        .btn-long {
      width: 100%;
    }

  </style>
</head>

<div class="container">
    <div class="row justify-content-between align-items-center col-md-6">
        <div class="col-auto">
            <a href="/dataset" class="btn btn-primary btn-long">Back</a>

        </div>
        <h1 class="mb-4"><?= $data['title'] ?></h1>
        <hr>

        <!-- Display flash messages (success or error) -->
        <?php if (session()->has('success')) : ?>
            <div class="alert alert-success"><?= session()->get('success') ?></div>
        <?php endif ?>
        <?php if (session()->has('error')) : ?>
            <div class="alert alert-danger"><?= session()->get('error') ?></div>
        <?php endif ?>


        <!-- File upload form -->
        <form id="uploadForm" action="/dataset/upload" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="profile_picture" class="form-label">Choose Dataset To Upload</label>
                <input type="file" class="form-control" id="dataset" name="dataset">
                <span id="fileError" class="text-danger" style="display: none;">Invalid file format or size</span>
            </div>

            <!-- add space between submit and delete button -->
            <button type="submit" class="btn btn-primary btn-short">Upload</button>
            <div style="height: 10px;"></div>
            <!-- Delete account -->
        </form>
    </div>
</div>

<!-- Custom JavaScript for file upload validation -->
<script>
    document.getElementById('uploadForm').addEventListener('submit', function(event) {
        var fileInput = document.getElementById('profile_picture');
        var file = fileInput.files[0];
    });
</script>