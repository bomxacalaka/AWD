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

<h1 class="mb-4"><?= $data['title']; ?></h1>
<hr>
<div class="container justify-content-center">
    
    <div class="row mb-3">
        
        <ul class="list-group">
            <?php foreach ($files as $file): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?php echo $file; ?>
                    <!-- Add a delete button/link -->
                    <form method="post" action="<?php echo base_url('/model/delete'); ?>">
                        <input type="hidden" name="filename" value="<?php echo $file; ?>">
                        <div class="container">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </form>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
        <div class="col-auto mt-3">
            <a href="/model/uploads" class="btn btn-primary">Upload</a>
        </div>