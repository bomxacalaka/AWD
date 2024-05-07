<head>
    <style>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<h1 class="mb-2">API Key Management</h1>
<!-- create key -->
<hr>
<div class="container">
    <button id="generate-api-key-btn" class="btn btn-primary">Generate API Key</button>
</div>

<div class="container mt-3 tbodyDiv">
    <!-- List of APIs -->
    <div id="api-keys-container">
        <ul class="list-group" id="api-key-list">
            <?php foreach ($apiKeys as $apiKey): ?>
                <div class="container mt-3 rounded" id="api-key-<?= $apiKey['id'] ?>">
                    <li id="api-key-<?= $apiKey['id'] ?>"
                        class="list-group-item d-flex align-items-center bg-dark">
                        <div class="container bg-secondary text-white rounded">
                            <?= $apiKey['api_key'] ?>
                        </div>
                        <div class="container">
                            <button class="btn btn-danger btn-sm delete-api-key-btn"
                                data-api-key-id="<?= $apiKey['id'] ?>">Delete</button>
                        </div>
                    </li>
                </div>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<script>
    $(document).ready(function () {
        // Function to generate API key
        $('#generate-api-key-btn').click(function (e) {
            e.preventDefault();
            $.get('<?= base_url('api-key/generate') ?>', function (response) {
                response = JSON.parse(response);
                if (response.status === 'success') {
                    // Append the newly generated API key to the list
                    $('#api-key-list').append(
                        '<div class="container mt-3 rounded" id="api-key-' + response.api_key_id + '">' +
                        '<li id="api-key-' + response.api_key_id +
                        '" class="list-group-item d-flex align-items-center bg-dark">' +
                        '<div class="container bg-secondary text-white rounded">' +
                        response.api_key +
                        '</div>' +
                        '<div class="container">' +
                        '<button class="btn btn-danger btn-sm delete-api-key-btn" data-api-key-id="' + response.api_key_id + '">Delete</button></li>' +
                        '</div>' +
                        '</div>'
                    );
                } else {
                    // Handle error
                    alert('Error: ' + response.message);
                }
            });
        });

        // Function to delete API key
        $(document).on('click', '.delete-api-key-btn', function (e) {
            e.preventDefault();
            var apiKeyId = $(this).closest('li').attr('id').replace('api-key-', '');
            $.get('<?= base_url('api-key/delete/') ?>' + apiKeyId, function (response) {
                response = JSON.parse(response);
                if (response.status === 'success') {
                    // Remove the deleted API key from the list
                    $('#api-key-' + apiKeyId).remove();
                } else {
                    // Handle error
                    alert('Error: ' + response.message);
                }
            });
        });
    });
</script>