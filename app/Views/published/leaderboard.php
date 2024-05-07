<head>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Additional CSS styles */
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
    </style>
</head>
<h1><?= $title ?></h1>
<hr>
<div class="container">
    <div class="table-responsive">
        <table class="table table-striped table-hover table-rounded">
            <thead>
                <tr>
                    <th>
                        <a href="?sort=name&order=<?= ($sort == 'name' && $order == 'ASC') ? 'desc' : 'asc' ?>">
                            Name <?= ($sort == 'name') ? ($order == 'ASC' ? '<i class="bi bi-caret-up"></i>' : '<i class="bi bi-caret-down"></i>') : '' ?>
                        </a>
                    </th>
                    <th>
                        <a href="?sort=loss&order=<?= ($sort == 'loss' && $order == 'ASC') ? 'desc' : 'asc' ?>">
                            Loss <?= ($sort == 'loss') ? ($order == 'ASC' ? '<i class="bi bi-caret-up"></i>' : '<i class="bi bi-caret-down"></i>') : '' ?>
                        </a>
                    </th>
                    <th>
                        <a href="?sort=accuracy&order=<?= ($sort == 'accuracy' && $order == 'ASC') ? 'desc' : 'asc' ?>">
                            Accuracy <?= ($sort == 'accuracy') ? ($order == 'ASC' ? '<i class="bi bi-caret-up"></i>' : '<i class="bi bi-caret-down"></i>') : '' ?>
                        </a>
                    </th>
                    <th>
                        <a href="?sort=model_name&order=<?= ($sort == 'model_name' && $order == 'ASC') ? 'desc' : 'asc' ?>">
                            Model <?= ($sort == 'model_name') ? ($order == 'ASC' ? '<i class="bi bi-caret-up"></i>' : '<i class="bi bi-caret-down"></i>') : '' ?>
                        </a>
                    </th>
                    <th>
                        <a href="?sort=dataset_name&order=<?= ($sort == 'dataset_name' && $order == 'ASC') ? 'desc' : 'asc' ?>">
                            Dataset <?= ($sort == 'dataset_name') ? ($order == 'ASC' ? '<i class="bi bi-caret-up"></i>' : '<i class="bi bi-caret-down"></i>') : '' ?>
                        </a>
                    </th>
                    <th>
                        <a href="?sort=model_timestamp&order=<?= ($sort == 'model_timestamp' && $order == 'ASC') ? 'desc' : 'asc' ?>">
                            Creation <?= ($sort == 'model_timestamp') ? ($order == 'ASC' ? '<i class="bi bi-caret-up"></i>' : '<i class="bi bi-caret-down"></i>') : '' ?>
                        </a>
                    </th>
                    <th>Actions</th> <!-- Added Actions column header -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($scores as $score): ?>
                    <tr>
                        <td><?= $score['name'] ?></td>
                        <td><?= $score['loss'] ?></td>
                        <td><?= $score['accuracy'] ?></td>
                        <td><?= $score['model_name'] ?></td>
                        <td><?= $score['dataset_name'] ?></td>
                        <td><?= $score['model_timestamp'] ?></td>
                        <td>
                            <!-- Button with link including model and user_id parameters -->
                            <a href="<?= base_url('test/quick') ?>?model=<?= $score['model_name'] ?>&user_id=<?= $score['user_id'] ?>" class="btn btn-primary">
                                Use
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
