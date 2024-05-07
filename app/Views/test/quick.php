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
        <!-- <div class="col-auto">
            <a href="/back" class="btn btn-secondary">Back</a>
        </div> -->
        <h1 class="mb-4"><?= $data['title'] ?></h1>
        <hr>
        <!-- Display flash messages (success or error) -->
        <?php if (session()->has('success')) : ?>
            <div class="alert alert-success"><?= session()->get('success') ?></div>
            <!-- set vars to data -->
            <?php session()->set('model', $data['model']); ?>
            <?php session()->set('user_id', $data['user_id']); ?>
        <?php endif ?>
        <?php if (session()->has('error')) : ?>
            <div class="alert alert-danger"><?= session()->get('error') ?></div>
        <?php endif ?>

        <!-- Display user's current profile picture (if available) -->
        <?php if ($data['user_id']) : ?>
            <img src="<?= base_url('/test/quick/pic/current/' . $data['user_id']) ?>" class="img-fluid rounded mb-4" alt="Profile Picture" width="200" height="200">
        <?php endif ?>

        <!-- File upload form -->
        <form id="uploadForm" action="/test/quick/pic" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="profile_picture" class="form-label">Choose Profile Picture</label>
                <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*">
                <span id="fileError" class="text-danger" style="display: none;">Invalid file format or size</span>
            </div>

            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
        <!-- button to predict, sends model and user_id as get and displays response -->
        <form id="predictForm" action="/test/quick/predict" method="get">
            <div class="mb-3">
                <input type="hidden" id="model" name="model" value="<?= $data['model'] ?>">
                <input type="hidden" id="user_id" name="user_id" value="<?= $data['user_id'] ?>">
            </div>
            <button type="submit" class="btn btn-primary">Predict</button>
        
    </div>
</div>