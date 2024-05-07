<head>
  <style>
        .btn-short {
      width: 40%;
    }
        .btn-long {
      width: 100%;
    }
    th {
            vertical-align: middle !important;
        }
        th a {
            display: inline-block;
            color: #000;
            text-decoration: none;
        }
        th a:hover {
            color: #000;
            text-decoration: none;
        }
        th i {
            font-size: 0.8rem;
            margin-left: 5px;
        }
        td {
            vertical-align: middle !important;
        }
        .table-rounded {
            border-radius: 15px;
            overflow: hidden;
        }
        .btn-primary {
      width: 100%;
      padding: 10px;
      background-color: #000;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .tbodyDiv{
max-width: clamp(0px, 90%, 90%);
overflow: auto;
}
  </style>
</head>

<h1 class="mb-4"><?= $data['title']; ?></h1>
<hr>
<div class="container justify-content-center">
  <div class="tbodyDiv">
<table class="table table-bordered table-striped text-center table-rounded">
        <tbody>
        <?php foreach ($files as $file): ?>
          <tr>
            <td><?php echo $file['name']; ?></td>
            <td><?php echo $file['size']; ?> MB</td>
            <td>
              <form method="post" action="<?php echo base_url('model/delete'); ?>">
                <input type="hidden" name="filename" value="<?php echo $file['name']; ?>">
                <button type="submit" class="btn btn-danger">Delete</button>
              </form>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
        
      </table>
    </div>
  </div>

  <div style="height: 10px;"></div>
  
  <div class="container">
  <div class="row">
    <div class="col-auto">
        <a href="/model/uploads" class="btn btn-primary">Upload</a>
    </div>
  </div>
</div>